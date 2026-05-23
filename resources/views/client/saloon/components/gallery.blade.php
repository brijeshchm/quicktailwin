 

@php



    $tabs = ['All', 'Salon', 'Hair', 'Makeup', 'Nails'];

 
    $photos= [
        ['id' => 1,  'url' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=600&q=80', 'cat' => 'Salon',  'label' => 'Premium Styling Suite'],
        ['id' => 2,  'url' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=600&q=80', 'cat' => 'Makeup', 'label' => 'Bridal Makeup Artistry'],
        ['id' => 3,  'url' => 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?w=600&q=80', 'cat' => 'Hair',   'label' => 'Balayage Masterpiece'],
        ['id' => 4,  'url' => 'https://images.unsplash.com/photo-1562322140-8baeececf3df?w=600&q=80', 'cat' => 'Salon',  'label' => 'Expert Consultation'],
        ['id' => 5,  'url' => 'https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?w=600&q=80', 'cat' => 'Makeup', 'label' => 'Evening Glam Look'],
        ['id' => 6,  'url' => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=600&q=80', 'cat' => 'Nails',  'label' => 'Nail Art Gallery'],
        ['id' => 7,  'url' => 'https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?w=600&q=80', 'cat' => 'Hair',   'label' => 'Precision Haircut'],
        ['id' => 8,  'url' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=600&q=80', 'cat' => 'Makeup', 'label' => 'Flawless Foundation'],
        ['id' => 9,  'url' => 'https://images.unsplash.com/photo-1633681122702-e661de478a03?w=600&q=80', 'cat' => 'Nails',  'label' => 'French Tips Elegance'],
        ['id' => 10, 'url' => 'https://images.unsplash.com/photo-1500840216050-6ffa99d75160?w=600&q=80', 'cat' => 'Hair',   'label' => 'Keratin Silky Smooth'],
        ['id' => 11, 'url' => 'https://images.unsplash.com/photo-1515688594390-b649af70d282?w=600&q=80', 'cat' => 'Salon',  'label' => 'Relaxing Ambience'],
        ['id' => 12, 'url' => 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?w=600&q=80', 'cat' => 'Salon',  'label' => 'Premium Experience'],
    ];

    /*
    |--------------------------------------------------------------------------
    | Brand accent (rose-600). Used for active tab + selected thumbnail border.
    |--------------------------------------------------------------------------
    */
    $accent_hex = '#e11d48';
    
@endphp

<section
    class="mx-auto max-w-7xl px-6 py-20"
    x-data="salonGallery({
        photos: {{ Js::from($photos) }},
        tabs:   {{ Js::from($tabs) }},
    })"
    @keydown.window.escape="if (lbOpen) closeLb()"
    @keydown.window.arrow-left="if (lbOpen && idx !== null) prevPhoto()"
    @keydown.window.arrow-right="if (lbOpen && idx !== null) nextPhoto()"
>
    {{-- ─── Header ───────────────────────────────────── --}}
    <div class="mb-10 text-center">
        <div class="mb-2.5 text-[0.62rem] font-extrabold uppercase tracking-[0.24em] text-rose-600">
            Our Work
        </div>
        <h2 class="mb-2.5 font-serif text-[clamp(2rem,4vw,3.2rem)] font-bold leading-tight text-stone-900">
            Gallery
        </h2>
        <p class="mx-auto mb-7 max-w-md text-[0.95rem] text-stone-500">
            Every look is a story. Explore our portfolio of transformations.
        </p>

        {{-- Filter tabs --}}
        <div class="flex flex-wrap justify-center gap-2">
            <template x-for="t in tabs" :key="t">
                <button
                    type="button"
                    @click="setTab(t)"
                    class="cursor-pointer rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-[0.1em] transition-all duration-200"
                    :class="tab === t
                        ? 'bg-gradient-to-br from-rose-600 to-rose-700 text-white shadow-md shadow-rose-600/35'
                        : 'bg-white text-stone-500 shadow-sm hover:text-rose-600'"
                    x-text="t"
                ></button>
            </template>
        </div>
    </div>

    {{-- ─── Masonry grid ─────────────────────────────── --}}
    <div
        class="gap-4 sm:[column-fill:balance]"
        style="columns: auto 260px;"
    >
        <template x-for="(p, i) in filtered" :key="p.id">
            <div
                @click="openLb(i)"
                class="group relative mb-4 inline-block w-full cursor-pointer overflow-hidden rounded-2xl break-inside-avoid"
            >
                <img
                    :src="p.url"
                    :alt="p.label"
                    loading="lazy"
                    class="block w-full rounded-2xl transition-all duration-300 ease-out group-hover:scale-[1.04] group-hover:brightness-[0.88]"
                >

                {{-- Hover overlay with caption — fixed: pure CSS group-hover, no JS --}}
                <div class="pointer-events-none absolute inset-x-0 bottom-0 rounded-b-2xl bg-gradient-to-t from-black/65 to-transparent p-3 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                    <div class="text-xs font-bold text-white" x-text="p.label"></div>
                </div>
            </div>
        </template>
    </div>

    {{-- ═══════════════════════════════════════════════
         LIGHTBOX
    ═══════════════════════════════════════════════ --}}
    <div
     

          x-show="lbOpen"
    x-transition.opacity.duration.250ms
    @click.self="closeLb()"
    class="fixed inset-0 z-[1001] flex items-center justify-center bg-black/90 backdrop-blur-md overflow-y-auto p-4"
    style="display: none;"
    >
        {{-- Close button (top-right of viewport) --}}
        <button
            type="button"
            @click="closeLb()"
            aria-label="Close gallery"
            class="absolute right-6 top-5 flex h-[38px] w-[38px] items-center justify-center rounded-full bg-white/15 text-base text-white transition-colors hover:bg-white/25"
        >✕</button>

        <div
            @click.stop
            class="w-full max-w-4xl"
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
        >
            {{-- ─── Lightbox tabs ──────────────────────── --}}
            <div class="mb-3.5 flex flex-wrap justify-center gap-1.5">
                <template x-for="t in tabs" :key="'lb-' + t">
                    <button
                        type="button"
                        @click="idx !== null ? switchLbTabPhoto(t) : switchLbTab(t)"
                        class="cursor-pointer rounded-full border-none px-3.5 py-1.5 text-[11px] font-bold uppercase tracking-[0.1em] text-white transition-all"
                        :class="lbTab === t ? 'bg-rose-600' : 'bg-white/10 hover:bg-white/20'"
                        x-text="t"
                    ></button>
                </template>
            </div>

            {{-- ─── Photo view ─────────────────────────── --}}
            <template x-if="idx !== null && currentPhoto">
                <div>
                    {{-- Main image --}}
                    <img
                        :src="currentPhoto.url"
                        :alt="currentPhoto.label"
                        :key="currentPhoto.id"
                        class="mx-auto block max-h-[60vh] w-full rounded-2xl object-contain"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                    >

                    {{-- Prev / counter / Next --}}
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <button
                            type="button"
                            @click="prevPhoto()"
                            :disabled="idx === 0"
                            class="rounded-[10px] border-none px-4 py-2.5 text-sm font-bold text-white transition-all"
                            :class="idx === 0
                                ? 'cursor-not-allowed bg-white/5'
                                : 'cursor-pointer bg-white/15 hover:bg-white/25'"
                        >← Prev</button>

                        <div class="text-center text-xs text-white/70">
                            <span x-text="currentPhoto.label"></span>
                            <span class="opacity-50">
                                (<span x-text="idx + 1"></span>/<span x-text="lbFiltered.length"></span>)
                            </span>
                        </div>

                        <button
                            type="button"
                            @click="nextPhoto()"
                            :disabled="idx === lbFiltered.length - 1"
                            class="rounded-[10px] border-none px-4 py-2.5 text-sm font-bold text-white transition-all"
                            :class="idx === lbFiltered.length - 1
                                ? 'cursor-not-allowed bg-white/5'
                                : 'cursor-pointer bg-white/15 hover:bg-white/25'"
                        >Next →</button>
                    </div>

                    {{-- Thumbnail strip --}}
                    <div class="mt-4 flex gap-2 overflow-x-auto pb-2" style="scrollbar-width: thin;">
                        <template x-for="(p, i) in lbFiltered" :key="'thumb-' + p.id">
                            <img
                                :src="p.url"
                                :alt="p.label"
                                @click="idx = i"
                                class="h-[60px] w-[60px] flex-shrink-0 cursor-pointer rounded-[10px] object-cover transition-all duration-150"
                                :class="i === idx
                                    ? 'border-[2.5px] border-rose-600 opacity-100'
                                    : 'border-2 border-transparent opacity-60 hover:opacity-90'"
                            >
                        </template>
                    </div>
                </div>
            </template>

            {{-- ─── Mosaic view (when no photo selected) ─── --}}
            <template x-if="idx === null">
                <div
                    class="max-h-[70vh] gap-3 overflow-auto"
                    style="columns: auto 160px;"
                >
                    <template x-if="lbFiltered.length === 0">
                        <div class="flex h-40 items-center justify-center text-sm text-white/40">
                            No photos in this category
                        </div>
                    </template>

                    <template x-for="(p, i) in lbFiltered" :key="'mosaic-' + p.id">
                        <div
                            @click="idx = i"
                            class="group relative mb-3 inline-block w-full cursor-pointer overflow-hidden rounded-xl break-inside-avoid"
                        >
                            <img
                                :src="p.url"
                                :alt="p.label"
                                loading="lazy"
                                class="block w-full rounded-xl transition-transform duration-200 group-hover:scale-[1.03]"
                            >
                        </div>
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
    function salonGallery({ photos, tabs }) {
        return {
            photos,
            tabs,
            tab:    'All',
            lbOpen: false,
            lbTab:  'All',
            idx:    null,

            /* ── Computed lists ───────────────────────────────── */
            get filtered() {
                return this.tab === 'All' ? this.photos : this.photos.filter(p => p.cat === this.tab);
            },

            get lbFiltered() {
                return this.lbTab === 'All' ? this.photos : this.photos.filter(p => p.cat === this.lbTab);
            },

            get currentPhoto() {
                if (this.idx === null) return null;
                return this.lbFiltered[this.idx] || null;
            },

            /* ── Main grid actions ────────────────────────────── */
            setTab(t) {
                this.tab = t;
            },

            openLb(filteredIndex) {
                this.lbTab = this.tab;     // start lightbox in the same category
                this.idx   = filteredIndex;
                this.lbOpen = true;
                document.body.style.overflow = 'hidden';
            },

            closeLb() {
                this.lbOpen = false;
                this.idx    = null;
                document.body.style.overflow = '';
            },

            /* ── Photo navigation ─────────────────────────────── */
            prevPhoto() {
                if (this.idx === null || this.idx === 0) return;
                this.idx -= 1;
            },

            nextPhoto() {
                if (this.idx === null) return;
                if (this.idx >= this.lbFiltered.length - 1) return;
                this.idx += 1;
            },

            /* ── Lightbox tab switching ───────────────────────── */
            switchLbTab(t) {
                this.lbTab = t;
                this.idx   = null;
            },

            switchLbTabPhoto(t) {
                this.lbTab = t;
                // If new category has photos, show first; else fall back to mosaic
                const next = (t === 'All' ? this.photos : this.photos.filter(p => p.cat === t));
                this.idx   = next.length > 0 ? 0 : null;
            },
        };
    }
</script>
