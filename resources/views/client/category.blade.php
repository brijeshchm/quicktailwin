@extends('client.layouts.app')
@section('title', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')
@section('description', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')
@section('keyword', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')
 
@section('content')	
 @include('client.components.banner-section')
   

 
<div class="bg-slate-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-2 text-slate-400 text-sm mb-3">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white">All Category</span>
        </div>
        <h1 class="text-4xl font-bold mb-2">Professional Courses &amp; Certifications</h1>
        <p class="text-slate-300 text-lg">Globally recognised training programmes from the world's leading institutions</p>
    </div>
</div>
 
{{-- =====================================================================
     MAIN CONTENT — Alpine.js component root
====================================================================== --}}
<div
    class="container mx-auto px-4 py-8"
    x-data="courseFilter()"
    x-init="init()"
>
    {{-- ---------------------------------------------------------------
         SEARCH + CONTROLS BAR
    --------------------------------------------------------------- --}}
    <div class="flex flex-col md:flex-row gap-3 mb-6">
 
        {{-- Search --}}
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1 0 4.5 4.5a7.5 7.5 0 0 0 12.15 12.15z"/>
            </svg>
            <input
                x-model="search"
                type="text"
                placeholder="Search courses or keywords..."
                class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl bg-white outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 text-sm transition-all"
            />
        </div>
 
        <div class="flex gap-2 flex-wrap">
            {{-- Sort --}}
            <select
                x-model="sortBy"
                class="px-3 py-3 border border-slate-200 rounded-xl bg-white text-sm outline-none focus:border-indigo-400 text-slate-700"
            >
                <option value="popular">Most Popular</option>
                <option value="rating">Highest Rated</option>
            </select>
 
            {{-- Grid toggle --}}
            <button
                @click="view = 'grid'"
                :class="view === 'grid'
                    ? 'bg-indigo-600 border-indigo-600 text-white'
                    : 'border-slate-200 bg-white text-slate-600 hover:border-indigo-300'"
                class="p-3 rounded-xl border transition-colors"
                title="Grid view"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h4v4H4V6zm6 0h4v4h-4V6zm6 0h4v4h-4V6zM4 14h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4z"/>
                </svg>
            </button>
 
            {{-- List toggle --}}
            <button
                @click="view = 'list'"
                :class="view === 'list'
                    ? 'bg-indigo-600 border-indigo-600 text-white'
                    : 'border-slate-200 bg-white text-slate-600 hover:border-indigo-300'"
                class="p-3 rounded-xl border transition-colors"
                title="List view"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
 
            {{-- Mobile filter toggle --}}
            <button
                @click="showFilters = !showFilters"
                class="md:hidden flex items-center gap-2 px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm text-slate-700"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 4h18M7 12h10M11 20h2"/>
                </svg>
                Filters
            </button>
        </div>
    </div>
 
    <div class="flex gap-8">
 
        {{-- ---------------------------------------------------------------
             SIDEBAR FILTERS
        --------------------------------------------------------------- --}}
        <aside
            :class="showFilters ? 'block' : 'hidden md:block'"
            class="w-64 shrink-0 space-y-5"
            x-cloak
        >
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="bg-slate-800 px-4 py-3">
                    <h3 class="text-white font-semibold text-sm">Filter Category</h3>
                </div>
                <div class="p-4 space-y-5">
                    <div class="space-y-2 max-h-64 overflow-y-auto pr-1">
                        @forelse ($categories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input
                                    type="checkbox"
                                    :value="'{{ $cat['url'] ?? '' }}'"
                                    x-model="selectedCategories"
                                    class="w-3.5 h-3.5 accent-indigo-600 cursor-pointer"
                                />
                                <span class="text-sm text-slate-700 group-hover:text-indigo-600 transition-colors">
                                    {{ $cat['name'] ?? '' }}
                                </span>
                                <span class="text-xs text-slate-400 ml-auto">
                                    ({{ $cat['count'] ?? 0 }})
                                </span>
                            </label>
                        @empty
                            <p class="text-xs text-slate-400">No categories available.</p>
                        @endforelse
                    </div>
 
                    {{-- Clear filters --}}
                    <button
                        x-show="selectedCategories.length > 0"
                        x-cloak
                        @click="selectedCategories = []"
                        class="w-full py-2 text-sm text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors"
                    >
                        Clear Filters
                    </button>
                </div>
            </div>
        </aside>
 
        {{-- ---------------------------------------------------------------
             COURSE LISTING
        --------------------------------------------------------------- --}}
        <div class="flex-1 min-w-0">
 
            {{-- Result count --}}
            <div class="flex items-center justify-between mb-5">
                <p class="text-slate-600 text-sm">
                    <span class="font-bold text-slate-900" x-text="filtered().length"></span> courses found
                </p>
            </div>
 
            {{-- ---- GRID VIEW ---- --}}
            <div
                x-show="view === 'grid'"
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5"
            >
                <template x-for="(course, index) in filtered()" :key="course.id">
                    <a
                        :href="'{{ url('categories') }}/' + course.url"
                        class="block h-full animate-fadein"
                        :style="`animation-delay: ${index * 60}ms`"
                    >
                        <div class="course-card bg-white border border-slate-200 rounded-xl overflow-hidden hover:border-indigo-300 group h-full flex flex-col">
 
                            {{-- Card image / header --}}
                            <div class="h-36 bg-gradient-to-br from-slate-100 to-indigo-50 flex items-center justify-center p-5 relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/10 group-hover:scale-110 transition-transform duration-500"></div>
                                <h3
                                    class="font-bold text-lg text-slate-700 group-hover:text-indigo-700 text-center leading-tight relative z-10"
                                    x-text="course.name"
                                ></h3>
                                <span
                                    class="absolute top-3 right-3 px-2 py-0.5 bg-white/90 text-indigo-700 text-xs font-semibold rounded-full border border-indigo-100 shadow-sm"
                                    x-text="course.category"
                                ></span>
                            </div>
 
                            {{-- Card body --}}
                            <div class="p-4 flex-1 flex flex-col">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-slate-700" x-text="course.category"></span>
                                    <div class="flex items-center gap-1 text-amber-500">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-xs font-medium text-slate-700" x-text="course.rating"></span>
                                    </div>
                                </div>
 
                                <div class="flex gap-3 text-xs text-slate-500 mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                                        </svg>
                                        120 hrs
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                        Advance
                                    </span>
                                </div>
 
                                <div class="flex items-center justify-between mt-auto pt-3 border-t border-slate-100">
                                    <span class="text-xs text-indigo-600 font-medium group-hover:translate-x-1 transition-transform flex items-center gap-0.5">
                                        View Details
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
 
            {{-- ---- LIST VIEW ---- --}}
            <div
                x-show="view === 'list'"
                x-cloak
                class="space-y-3"
            >
                <template x-for="(course, idx) in filtered()" :key="course.id">
                    <a
                        :href="'{{ url('categories') }}/' + course.url"
                        class="block animate-fadein"
                        :style="`animation-delay: ${idx * 40}ms`"
                    >
                        <div class="course-card bg-white border border-slate-200 rounded-xl p-5 hover:border-indigo-300 group flex items-start gap-5">
 
                            {{-- Index badge --}}
                            <div
                                class="w-14 h-14 shrink-0 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-700 font-bold text-xl border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-colors"
                                x-text="idx + 1"
                            ></div>
 
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 flex-wrap">
                                    <div>
                                        <h3
                                            class="font-bold text-slate-900 group-hover:text-indigo-700 transition-colors"
                                            x-text="course.category"
                                        ></h3>
                                        <p class="text-sm text-slate-500 mt-0.5" x-text="course.name"></p>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center gap-1 justify-end">
                                            <svg class="w-3.5 h-3.5 fill-amber-400 text-amber-400" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span
                                                class="text-xs text-slate-600"
                                                x-text="`${course.rating} (${(course.ratingcount / 1000).toFixed(1)}k)`"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
 
                                <p class="text-sm text-slate-500 mt-2 line-clamp-2" x-text="course.description"></p>
 
                                <div class="flex items-center gap-2 mt-2">
                                    <span
                                        class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full border border-indigo-100"
                                        x-text="course.name"
                                    ></span>
                                    <span class="flex items-center gap-1 text-xs text-slate-400">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span x-text="Number(course.ratingcount).toLocaleString() + ' enrolled'"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
 
            {{-- Empty state --}}
            <div
                x-show="filtered().length === 0"
                x-cloak
                class="text-center py-16"
            >
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-slate-500 text-lg font-medium">No courses match your filters.</p>
                <p class="text-slate-400 text-sm mt-2">Try adjusting your search or clearing the filters.</p>
            </div>
 
        </div>{{-- /.flex-1 --}}
    </div>{{-- /.flex.gap-8 --}}
</div>{{-- /Alpine root --}}
 


{{-- =====================================================================
     ALPINE.JS DATA — pass PHP → JS via @json
====================================================================== --}}
<script>
    function courseFilter() {
        return {
            /* ── raw data from PHP ── */
            allCourses: @json($categories),
 
            /* ── reactive state ── */
            search:             '',
            selectedCategories: [],
            sortBy:             'popular',
            view:               'grid',
            showFilters:        false,
 
            init() {
                /* no async needed – data comes from PHP */
            },
 
            filtered() {
                let list = this.allCourses.filter(course => {
                    const q = this.search.toLowerCase();
 
                    const matchesSearch =
                        !q ||
                        (course.name     ?? '').toLowerCase().includes(q) ||
                        (course.url     ?? '').toLowerCase().includes(q) ||
                        (course.slug ?? '').toLowerCase().includes(q);
 
                    const matchesCat =
                        this.selectedCategories.length === 0 ||
                        this.selectedCategories.includes(course.url);
 
                    return matchesSearch && matchesCat;
                });
 
                if (this.sortBy === 'popular') {
                    list = list.slice().sort((a, b) => (b.ratingcount ?? 0) - (a.ratingcount ?? 0));
                } else if (this.sortBy === 'rating') {
                    list = list.slice().sort((a, b) => (b.rating ?? 0) - (a.rating ?? 0));
                }
 
                return list;
            },
        };
    }
</script>



@endsection