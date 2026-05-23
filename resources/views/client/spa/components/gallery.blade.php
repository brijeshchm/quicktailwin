

@php



    $gridTabs     = ['All', 'Interiors', 'Treatments', 'Staff', 'Products'];
    $lbTabs = ['All', 'Interiors', 'Treatments', 'Videos'];

   
    $items = [
        ['img' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800&auto=format&q=80', 'cat' => 'Interiors',  'h' => 280],
        ['img' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=800&auto=format&q=80', 'cat' => 'Treatments', 'h' => 190],
        ['img' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&auto=format&q=80', 'cat' => 'Treatments', 'h' => 190],
        ['img' => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=800&auto=format&q=80', 'cat' => 'Interiors',  'h' => 240],
        ['img' => 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=800&auto=format&q=80', 'cat' => 'Treatments', 'h' => 280],
        ['img' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&auto=format&q=80', 'cat' => 'Staff',      'h' => 210],
        ['img' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=800&auto=format&q=80', 'cat' => 'Treatments', 'h' => 190],
        ['img' => 'https://images.unsplash.com/photo-1560750588-73207b1ef5b8?w=800&auto=format&q=80', 'cat' => 'Interiors',  'h' => 200],
        ['img' => 'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?w=800&auto=format&q=80', 'cat' => 'Products',   'h' => 200],
        ['img' => 'https://images.unsplash.com/photo-1552693673-1bf958298935?w=800&auto=format&q=80', 'cat' => 'Interiors',  'h' => 190],
        ['img' => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=800&auto=format&q=80', 'cat' => 'Treatments', 'h' => 230],
        ['img' => 'https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=800&auto=format&q=80', 'cat' => 'Products',   'h' => 180],
        ['img' => 'https://images.unsplash.com/photo-1583416750470-965b2707b355?w=800&auto=format&q=80', 'cat' => 'Treatments', 'h' => 210],
        ['img' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&auto=format&q=80', 'cat' => 'Staff',      'h' => 190],
        ['img' => 'https://images.unsplash.com/photo-1507652313519-d4e9174996dd?w=800&auto=format&q=80', 'cat' => 'Interiors',  'h' => 260],
        ['img' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800&auto=format&q=80', 'cat' => 'Treatments', 'h' => 220, 'is_video' => true],
        ['img' => 'https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?w=800&auto=format&q=80', 'cat' => 'Interiors',  'h' => 200, 'is_video' => true],
        ['img' => 'https://images.unsplash.com/photo-1493666438817-866a91353ca9?w=800&auto=format&q=80', 'cat' => 'Staff',      'h' => 220, 'is_video' => true],
    ];

   
    $brandLetter = 'S';
 

    // Normalize is_video flag for every item
    $items = array_map(function ($it) {
        return [
            'img'      => $it['img'],
            'cat'      => $it['cat'],
            'h'        => (int) $it['h'],
            'is_video' => !empty($it['is_video']),
        ];
    }, $items);
@endphp

<section
    id="gallery"
    class="mx-auto max-w-7xl px-6 py-10"
    x-data="galleryApp({
        items: {{ Js::from($items) }},
        gridTabs: {{ Js::from($gridTabs) }},
        lbTabs: {{ Js::from($lbTabs) }},
    })"
    x-init="init($el)"
    @keydown.window.escape="onEscape()"
    @keydown.window.arrow-left="if (photoIdx !== null) prevPhoto()"
    @keydown.window.arrow-right="if (photoIdx !== null) nextPhoto()"
>

    {{-- ─── Compact header with tab strip ───────────────────── --}}
    <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-baseline gap-4">
            <h2 class="font-serif text-[1.7rem] font-bold text-slate-900">
                Gallery
                <span class="bg-gradient-to-r from-amber-400 via-orange-500 to-amber-600 bg-clip-text text-transparent">·</span>
            </h2>
            <span class="text-xs font-semibold text-slate-400" x-text="`${mainVisible.length} photos`"></span>
        </div>

        <div class="flex flex-wrap gap-1.5">
            <template x-for="t in gridTabs" :key="t">
                <button
                    @click="tab = t"
                    class="rounded-full px-3.5 py-1.5 text-xs font-bold uppercase tracking-wider transition-all"
                    :class="tab === t
                        ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-md shadow-orange-500/30'
                        : 'border border-slate-200 bg-white text-slate-500 hover:border-orange-300 hover:text-orange-600'"
                    x-text="t"
                ></button>
            </template>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         MOBILE COLLAGE (visible < 600px)
    ═══════════════════════════════════════════════════════ --}}
    <div class="block sm:hidden">

        {{-- Block 1: 2fr/1fr layout, first 3 items --}}
        <template x-if="mainVisible.length >= 1">
            <div class="mb-1.5 grid grid-cols-[2fr_1fr] grid-rows-[140px_140px] gap-1.5">
                <template x-for="(item, i) in mainVisible.slice(0, 3)" :key="'m1-' + i">
                    <div
                        @click="openGallery()"
                        class="relative cursor-pointer overflow-hidden rounded-xl bg-slate-200"
                        :class="i === 0 ? 'col-start-1 row-span-2' : (i === 1 ? 'col-start-2 row-start-1' : 'col-start-2 row-start-2')"
                    >
                        <img :src="item.img" alt="" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                        <template x-if="item.is_video">
                            <span class="absolute inset-0 flex items-center justify-center bg-black/30 text-xl text-white">▶</span>
                        </template>
                    </div>
                </template>
            </div>
        </template>

        {{-- Block 2: 3 equal columns, items 3-5 --}}
        <template x-if="mainVisible.length > 3">
            <div class="mb-1.5 grid grid-cols-3 gap-1.5">
                <template x-for="(item, i) in mainVisible.slice(3, 6)" :key="'m2-' + i">
                    <div
                        @click="openGallery()"
                        class="relative h-[110px] cursor-pointer overflow-hidden rounded-xl bg-slate-200"
                    >
                        <img :src="item.img" alt="" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                        <template x-if="item.is_video">
                            <span class="absolute inset-0 flex items-center justify-center bg-black/30 text-xl text-white">▶</span>
                        </template>
                    </div>
                </template>
            </div>
        </template>

        {{-- Block 3: flipped 1fr/2fr layout, items 6-8 --}}
        <template x-if="mainVisible.length > 6">
            <div class="mb-1.5 grid grid-cols-[1fr_2fr] grid-rows-[140px_140px] gap-1.5">
                <template x-for="(item, i) in mainVisible.slice(6, 9)" :key="'m3-' + i">
                    <div
                        @click="openGallery()"
                        class="relative cursor-pointer overflow-hidden rounded-xl bg-slate-200"
                        :class="i === 0 ? 'col-start-2 row-span-2' : (i === 1 ? 'col-start-1 row-start-1' : 'col-start-1 row-start-2')"
                    >
                        <img :src="item.img" alt="" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                        <template x-if="item.is_video">
                            <span class="absolute inset-0 flex items-center justify-center bg-black/30 text-xl text-white">▶</span>
                        </template>
                    </div>
                </template>
            </div>
        </template>

        {{-- Block 4: 2-column rest --}}
        <template x-if="mainVisible.length > 9">
            <div class="mt-1.5 grid grid-cols-2 gap-1.5">
                <template x-for="(item, i) in mainVisible.slice(9)" :key="'mr-' + i">
                    <div
                        @click="openGallery()"
                        class="relative h-[130px] cursor-pointer overflow-hidden rounded-xl bg-slate-200"
                    >
                        <img :src="item.img" alt="" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                        <template x-if="item.is_video">
                            <span class="absolute inset-0 flex items-center justify-center bg-black/30 text-xl text-white">▶</span>
                        </template>
                    </div>
                </template>
            </div>
        </template>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         DESKTOP MASONRY (visible ≥ 600px)
    ═══════════════════════════════════════════════════════ --}}
    <div
        class="hidden sm:block"
        style="column-gap: 6px; column-count: 2;"
        :style="`column-gap: 6px;`"
    >
        <style>
            #gallery .masonry-grid { column-count: 4; }
            @media (max-width: 1100px) { #gallery .masonry-grid { column-count: 3; } }
            @media (max-width: 720px)  { #gallery .masonry-grid { column-count: 2; } }
        </style>

        <div class="masonry-grid" style="column-gap: 6px;">
            <template x-for="(item, i) in mainVisible" :key="item.img + '-d-' + i">
                <div
                    @click="openGallery(i)"
                    data-gallery-item
                    class="group mb-1.5 block cursor-pointer overflow-hidden rounded-lg shadow-[0_2px_12px_rgba(0,0,0,0.10)] transition-all duration-300 hover:shadow-[0_16px_48px_rgba(249,115,22,0.28)]"
                    :style="`
                        break-inside: avoid;
                        height: ${Math.round(item.h * 0.52)}px;
                        opacity: 0;
                        transform: translateY(24px);
                        transition: opacity 0.6s ease ${i*45}ms, transform 0.6s ease ${i*45}ms, box-shadow 0.28s ease;
                    `"
                >
                    <div class="relative h-full w-full">
                        <img
                            :src="item.img"
                            alt=""
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                        {{-- Hover tint --}}
                        <div class="absolute inset-0 bg-orange-500/0 transition-colors duration-300 group-hover:bg-orange-500/[0.14]"></div>
                        {{-- Video play badge --}}
                        <template x-if="item.is_video">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-white/70 bg-black/50 pl-1 text-white backdrop-blur-sm">▶</div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         FLOATING TOP BAR (above both lightbox layers)
    ═══════════════════════════════════════════════════════ --}}
    <div
        x-show="galleryOpen"
        x-transition.opacity
        class="fixed inset-x-0 top-0 z-[1003] flex items-center justify-between border-b border-white/10 bg-black/70 px-3 py-2.5 backdrop-blur-xl"
        style="pointer-events: none;"
    >
        {{-- Left: back-to-mosaic button OR title --}}
        <template x-if="photoIdx !== null">
            <button
                @click="closePhoto()"
                style="pointer-events: auto;"
                class="inline-flex items-center gap-1.5 rounded-lg border-[1.5px] border-white/15 bg-white/10 px-3.5 py-2 text-xs font-bold text-white transition-colors hover:bg-white/20"
            >
                ← Gallery
            </button>
        </template>

        <template x-if="photoIdx === null">
            <div class="flex items-center gap-2" style="pointer-events: auto;">
                <div class="flex h-7 w-7 items-center justify-center rounded-md bg-gradient-to-br from-orange-500 to-orange-600 font-serif text-sm font-black text-white">
                    {{ $brandLetter }}
                </div>
                <span class="text-[0.82rem] font-bold text-white" x-text="`Gallery · ${lbItems.length} photos`"></span>
            </div>
        </template>

        {{-- Center: counter (photo view only) --}}
        <template x-if="photoIdx !== null">
            <div class="rounded-full border border-orange-500/45 bg-orange-500/20 px-3 py-1 text-[11px] font-bold text-orange-400">
                <span x-text="(photoIdx + 1) + ' / ' + lbItems.length"></span>
            </div>
        </template>

        {{-- Right: close all --}}
        <button
            @click="closeAll()"
            style="pointer-events: auto;"
            class="flex h-[38px] w-[38px] items-center justify-center rounded-[10px] border-2 border-red-500/50 bg-red-500/20 text-base font-black text-red-300 transition-all hover:bg-red-500/30"
        >
            ✕
        </button>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         LAYER 1 — Mosaic popup
    ═══════════════════════════════════════════════════════ --}}
    <div
        x-show="galleryOpen && photoIdx === null"
        x-transition.opacity.duration.220ms
        class="fixed inset-0 z-[1001] flex flex-col bg-[rgba(10,6,3,0.97)] pt-[52px] backdrop-blur-2xl"
        style="display: none;"
    >
        {{-- Filter tabs --}}
        <div class="flex-shrink-0 border-b border-white/10 bg-black/65 backdrop-blur-md">
            <div class="flex gap-1.5 overflow-x-auto px-5 py-2.5" style="scrollbar-width: none;">
                <template x-for="t in lbTabs" :key="'lb1-' + t">
                    <button
                        @click="switchLbTab(t)"
                        class="flex-shrink-0 rounded-full px-4 py-1.5 text-[11px] font-extrabold uppercase tracking-wider transition-all"
                        :class="lbTab === t
                            ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-md shadow-orange-500/45'
                            : 'border-[1.5px] border-white/20 bg-white/5 text-white/65 hover:bg-white/10'"
                        x-text="t"
                    ></button>
                </template>
            </div>
        </div>

        {{-- Scrollable mosaic --}}
        <div class="flex-1 overflow-y-auto px-5 pb-20 pt-4">
            <template x-if="lbItems.length === 0">
                <div class="flex h-52 items-center justify-center text-sm text-white/35">
                    No photos in this category
                </div>
            </template>

            <template x-if="lbItems.length > 0">
                <div style="columns: 3 160px; column-gap: 5px;">
                    <template x-for="(item, i) in lbItems" :key="'lb1-img-' + item.img + i">
                        <div
                            @click="openPhoto(i)"
                            class="group relative mb-1.5 cursor-pointer overflow-hidden rounded-lg shadow-[0_2px_12px_rgba(0,0,0,0.4)] transition-all duration-200 hover:scale-[1.02] hover:shadow-[0_8px_32px_rgba(249,115,22,0.35)]"
                            :style="`break-inside: avoid; height: ${Math.round(item.h * 0.48)}px;`"
                        >
                            <img :src="item.img" alt="" loading="lazy" class="h-full w-full object-cover">
                            <template x-if="item.is_video">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-full border-[2.5px] border-white/75 bg-black/55 pl-1 text-base text-white backdrop-blur-sm">▶</div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         LAYER 2 — Single photo viewer
    ═══════════════════════════════════════════════════════ --}}
    <div
        x-show="galleryOpen && photoIdx !== null && currentPhoto"
        x-transition.opacity.duration.180ms
        class="fixed inset-0 z-[1002] flex flex-col bg-[rgba(4,2,1,0.98)] pt-[52px] backdrop-blur-2xl"
        style="display: none;"
    >
        {{-- Filter tabs (jump to first photo in selected tab) --}}
        <div class="flex-shrink-0 border-b border-white/10 bg-black/65 backdrop-blur-md">
            <div class="flex gap-1.5 overflow-x-auto px-5 py-2.5" style="scrollbar-width: none;">
                <template x-for="t in lbTabs" :key="'lb2-' + t">
                    <button
                        @click="switchLbTabPhoto(t)"
                        class="flex-shrink-0 rounded-full px-4 py-1.5 text-[11px] font-extrabold uppercase tracking-wider transition-all"
                        :class="lbTab === t
                            ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-md shadow-orange-500/45'
                            : 'border-[1.5px] border-white/20 bg-white/5 text-white/65 hover:bg-white/10'"
                        x-text="t"
                    ></button>
                </template>
            </div>
        </div>

        {{-- Photo area with swipe support --}}
        <div
            class="relative flex flex-1 items-center justify-center px-2 sm:px-16"
            @touchstart="touchStartX = $event.touches[0].clientX; touchStartY = $event.touches[0].clientY"
            @touchend="onSwipeEnd($event)"
        >
            {{-- Prev arrow (desktop only) --}}
            <button
                @click="prevPhoto()"
                class="absolute left-3 top-1/2 z-10 hidden h-[46px] w-[46px] -translate-y-1/2 items-center justify-center rounded-full border-2 border-orange-500/50 bg-orange-500/20 text-lg text-white transition-colors hover:bg-orange-500/40 sm:flex"
                aria-label="Previous photo"
            >❮</button>

            {{-- Image card --}}
            <div
                class="relative w-full max-w-[760px] overflow-hidden rounded-2xl shadow-[0_40px_100px_rgba(0,0,0,0.8)]"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
            >
                <div class="relative bg-[#111]">
                    <img
                        :key="currentPhoto?.img"
                        :src="currentPhoto?.img"
                        alt=""
                        class="block max-h-[72vh] w-full object-cover"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-105"
                        x-transition:enter-end="opacity-100 scale-100"
                    >
                    <template x-if="currentPhoto?.is_video">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="flex h-[72px] w-[72px] items-center justify-center rounded-full border-[3px] border-white/85 bg-black/60 pl-1.5 text-2xl text-white backdrop-blur-md">▶</div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Next arrow (desktop only) --}}
            <button
                @click="nextPhoto()"
                class="absolute right-3 top-1/2 z-10 hidden h-[46px] w-[46px] -translate-y-1/2 items-center justify-center rounded-full border-2 border-orange-500/50 bg-orange-500/20 text-lg text-white transition-colors hover:bg-orange-500/40 sm:flex"
                aria-label="Next photo"
            >❯</button>
        </div>

        {{-- Swipe hint (mobile only) --}}
        <div class="block flex-shrink-0 px-0 pt-1.5 pb-0.5 text-center text-[11px] font-bold tracking-wider text-white/35 sm:hidden">
            ← Swipe to browse →
        </div>

        {{-- Thumbnail strip --}}
        <div
            class="flex flex-shrink-0 gap-1.5 overflow-x-auto border-t border-white/10 bg-black/55 px-5 py-2.5 backdrop-blur-md"
            style="scrollbar-width: none;"
        >
            <template x-for="(thumb, i) in lbItems" :key="'thumb-' + thumb.img + i">
                <div
                    @click="photoIdx = i"
                    class="relative h-[52px] w-[52px] flex-shrink-0 cursor-pointer overflow-hidden rounded-[9px] border-[2.5px] transition-all duration-200"
                    :class="i === photoIdx
                        ? 'border-orange-500 scale-110 shadow-[0_0_0_2px_rgba(249,115,22,0.4)]'
                        : 'border-white/15'"
                >
                    <img :src="thumb.img" alt="" class="h-full w-full object-cover">
                    <template x-if="thumb.is_video">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30 text-[10px] text-white">▶</div>
                    </template>
                </div>
            </template>
        </div>
    </div>

</section>

{{-- ═══════════════════════════════════════════════════════════
     ALPINE COMPONENT LOGIC
═══════════════════════════════════════════════════════════ --}}
<script>
    function galleryApp({ items, gridTabs, lbTabs }) {
        return {
            items,
            gridTabs,
            lbTabs,
            tab: 'All',
            galleryOpen: false,
            lbTab: 'All',
            photoIdx: null,
            touchStartX: 0,
            touchStartY: 0,

            /* ── Computed-style getters ───────────────────────── */
            get mainVisible() {
                return this.tab === 'All'
                    ? this.items
                    : this.items.filter(i => i.cat === this.tab);
            },

            get lbItems() {
                if (this.lbTab === 'All')    return this.items;
                if (this.lbTab === 'Videos') return this.items.filter(i => i.is_video);
                return this.items.filter(i => i.cat === this.lbTab);
            },

            get currentPhoto() {
                return this.photoIdx !== null ? this.lbItems[this.photoIdx] : null;
            },

            /* ── Lifecycle / scroll reveal ─────────────────────── */
            init(root) {
                this.$nextTick(() => this.observeReveal(root));
                // Re-run reveal whenever tab changes
                this.$watch('tab', () => this.$nextTick(() => this.observeReveal(root)));
            },

            observeReveal(root) {
                const cards = root.querySelectorAll('[data-gallery-item]');
                if (!('IntersectionObserver' in window)) {
                    cards.forEach(c => { c.style.opacity = 1; c.style.transform = 'none'; });
                    return;
                }
                const io = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = 1;
                            entry.target.style.transform = 'translateY(0)';
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.04 });
                cards.forEach(c => io.observe(c));
            },

            /* ── Open / close ─────────────────────────────────── */
            openGallery(startIdx) {
                this.lbTab = 'All';
                this.galleryOpen = true;
                this.photoIdx = (typeof startIdx === 'number') ? startIdx : null;
                document.body.style.overflow = 'hidden';
            },

            closeAll() {
                this.galleryOpen = false;
                this.photoIdx = null;
                document.body.style.overflow = '';
            },

            closePhoto() {
                this.photoIdx = null;
            },

            openPhoto(idx) {
                this.photoIdx = idx;
            },

            onEscape() {
                if (!this.galleryOpen) return;
                if (this.photoIdx !== null) this.closePhoto();
                else this.closeAll();
            },

            /* ── Lightbox tab switching ───────────────────────── */
            switchLbTab(t) {
                this.lbTab = t;
                this.photoIdx = null;
            },

            switchLbTabPhoto(t) {
                this.lbTab = t;
                this.photoIdx = 0;
            },

            /* ── Photo navigation ─────────────────────────────── */
            prevPhoto() {
                if (this.photoIdx === null || this.lbItems.length === 0) return;
                this.photoIdx = (this.photoIdx - 1 + this.lbItems.length) % this.lbItems.length;
            },

            nextPhoto() {
                if (this.photoIdx === null || this.lbItems.length === 0) return;
                this.photoIdx = (this.photoIdx + 1) % this.lbItems.length;
            },

            /* ── Touch swipe ──────────────────────────────────── */
            onSwipeEnd(e) {
                const dx = e.changedTouches[0].clientX - this.touchStartX;
                const dy = e.changedTouches[0].clientY - this.touchStartY;
                if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 50) {
                    if (dx < 0) this.nextPhoto();
                    else this.prevPhoto();
                }
            },
        };
    }
</script>
