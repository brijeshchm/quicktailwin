
@php
  $gradients = ['from-rose-500 to-orange-400','from-indigo-500 to-purple-600','from-teal-400 to-cyan-500','from-blue-600 to-violet-600','from-emerald-400 to-teal-600','from-amber-500 to-red-500'];

@endphp
<section style="background:linear-gradient(135deg,#faf5ff 0%,#ede9fe 40%,#f0f9ff 100%);">
    <div class="w-full px-8 md:px-16 py-10">
        <div class="reveal mb-12 flex flex-col items-center text-center gap-5">
            <span class="section-badge" style="background:rgba(168,85,247,.12);color:#7c3aed;border:1px solid rgba(168,85,247,.25);">Customer Reviews</span>
            <h2 class="heading-ul text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">What People Say</h2>
            <button onclick="document.getElementById('review-form-modal').classList.add('open')"
                    class="flex items-center justify-center gap-2.5 px-7 py-4 rounded-2xl font-bold text-base text-white"
                    style="background:linear-gradient(135deg,#6d28d9,#a855f7,#ec4899);box-shadow:0 4px 24px rgba(124,58,237,.4);">
                ★ Write Your Review
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Summary --}}
            <div class="lg:col-span-1">
                <div class="rounded-2xl p-8 sticky top-20 border" style="background:linear-gradient(135deg,#2563EB,#0891b2);">
                    <h3 class="text-lg font-bold text-white/80 mb-4">Overall Rating</h3>
                    <div class="flex items-end gap-3 mb-6">
                        <span class="text-6xl font-extrabold tracking-tighter leading-none text-white">{{ $clientsList['rating'] ?? '5' }}</span>
                        <div class="pb-1.5">
                            <div class="flex text-yellow-400 mb-1">★★★★★</div>
                            <span class="text-sm text-white/60">{{ $clientsList['ratingCount'] ?? '' }} reviews</span>
                        </div>
                    </div>
                    <div class="space-y-2.5">
                        @foreach([85,10,3,1,1] as $i => $pct)
                        <div class="flex items-center gap-2">
                            <span class="w-3 text-xs text-white/50 text-right">{{ 5-$i }}</span>
                            <span class="text-yellow-400 text-xs">★</span>
                            <div class="flex-1 h-2 rounded-full overflow-hidden" style="background:rgba(255,255,255,.2);">
                                <div class="h-full rounded-full bg-white" style="width:{{ $pct }}%;"></div>
                            </div>
                            <span class="w-8 text-xs text-white/50">{{ $pct }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Review cards --}}
            <div class="lg:col-span-2 flex flex-col gap-4">
                {{-- Filter row --}}
                <div class="flex flex-wrap gap-2" id="review-filters">
                    @foreach(['all'=>'All','5'=>'5★','4'=>'4★','3'=>'3★','2'=>'2★','1'=>'1★'] as $key => $label)
                    <button class="review-filter-btn px-3 py-1.5 rounded-full text-xs font-bold transition-all {{ $key==='all'?'text-white':'text-purple-700'}} "
                            style="{{ $key==='all'?'background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 12px rgba(124,58,237,.35);':'background:rgba(124,58,237,.08);border:1px solid rgba(124,58,237,.18);' }}"
                            data-filter="{{ $key }}" onclick="filterReviews(this, '{{ $key }}')">
                        {{ $label }}
                    </button>
                    @endforeach
                </div>

                <div class="h-px" style="background:rgba(124,58,237,.1);"></div>

                <div id="review-list" class="flex flex-col gap-4">
                    @forelse($reviews as $i => $review)
                    @php
                    
                    $grad = $gradients[$i % count($gradients)];
                    $author = $review['comment_author'] ?? 'Anonymous';
                    $initials = strtoupper(substr($author,0,2));
                    $rating = (int)($review['rating'] ?? 5);
                    @endphp
                    <div class="review-card reveal d-{{ min($i%6,5) }} rounded-2xl p-6 border"
                         data-rating="{{ $rating }}">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 shrink-0 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md bg-gradient-to-br {{ $grad }}">
                                {{ $initials }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center flex-wrap gap-2 mb-1">
                                    <h4 class="font-bold text-gray-900">{{ $author }}</h4>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full"
                                          style="background:rgba(34,197,94,.1);color:#15803d;border:1px solid rgba(34,197,94,.2);">
                                        ✓ Verified
                                    </span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="flex text-yellow-400">
                                        @for($s=0;$s<5;$s++)<span class="text-sm {{ $s<$rating?'text-yellow-400':'text-gray-200' }}">★</span>@endfor
                                    </div>
                                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($review['created_at'] ?? now())->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-500 leading-relaxed text-sm">"{{ $review['comment_content'] ?? 'Great experience!' }}"</p>
                    </div>
                    @empty
                    <div class="py-12 text-center rounded-2xl" style="background:rgba(124,58,237,.04);border:1px dashed rgba(124,58,237,.2);">
                        <p class="font-bold text-gray-400 text-sm">No reviews yet. Be the first!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>