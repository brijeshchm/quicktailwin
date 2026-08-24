{{-- ─────────────────────────────────────────
    STATS BANNER
───────────────────────────────────────── --}}
<section class="py-10 md:py-16 relative overflow-hidden bg-gray-900">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-blue-500 opacity-95"></div>
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image:url('img/client-count.png')"></div>
    <!--<div class="w-full px-4 md:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-12">
            @foreach([
                ['value' => $citieslists, 'label' => 'Cities Covered'],
                ['value' => $clients,  'label' => 'Listed Businesses'],
                ['value' => $childCategory,  'label' => 'Categories'],
                ['value' => $keywordCount,    'label' => 'Keywords'],
            ] as $stat)
            <div class="text-center stat-item">
                <h3 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mb-1.5 drop-shadow-sm">{{ $stat['value'] }}</h3>
                <p class="text-white/80 font-medium text-xs md:text-sm uppercase tracking-wider">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>-->
</section>
