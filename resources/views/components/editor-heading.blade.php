@props([
    'title' => '',
    'subtitle' => '',
    'eyebrow' => null,
])

<div class="border-b border-[#edf1f3] p-5 sm:p-7">

    @if($eyebrow)
        <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#a14f47]">
            {{ $eyebrow }}
        </p>
    @endif

    <h2 class="mt-1 font-display text-2xl font-semibold tracking-[-0.04em] text-[#243746]">
        {{ $title }}
    </h2>

    @if($subtitle)
        <p class="mt-1 max-w-2xl text-sm leading-6 text-[#718394]">
            {{ $subtitle }}
        </p>
    @endif

</div>