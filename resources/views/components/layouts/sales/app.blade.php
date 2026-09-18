@props(['title' => 'Vendorflow Admin', 'header' => 'Sales workspace'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Vendorflow Admin' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->

        <script src="https://cdn.tailwindcss.com"></script>

            <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
</head>
<body class="bg-[#f7f9fb] text-[#12263a]">
    <div class="min-h-screen">
        <header class="fixed inset-x-0 top-0 z-30 h-[68px] border-b border-[#dfe7ec] bg-white/95 backdrop-blur lg:pl-[248px]">
            <div class="flex h-full items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <button data-mobile-menu-toggle class="grid h-10 w-10 place-items-center rounded-xl text-[#435b6d] hover:bg-[#f1f5f7] lg:hidden" aria-label="Open navigation"><span class="text-xl">☰</span></button>
                    <span class="hidden text-sm font-semibold text-[#435b6d] sm:inline">{{ $header ?? 'Sales workspace' }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <button class="relative grid h-9 w-9 place-items-center rounded-xl text-[#718394] hover:bg-[#f1f5f7]" aria-label="Notifications"><span class="text-lg">⌁</span><span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-[#a14f47]"></span></button>
                    <div class="hidden text-right sm:block"><p class="text-xs font-semibold text-[#435b6d]">{{ auth()->user()->name ?? 'Sales Admin' }}</p><p class="text-[11px] text-[#9aa9b5]">{{ auth()->user()->email ?? 'admin@example.com' }}</p></div>
                    <div class="grid h-9 w-9 place-items-center rounded-xl bg-[#e9f2f7] text-xs font-bold text-[#315b80]">{{ collect(explode(' ', auth()->user()->name ?? 'Sales Admin'))->map(fn ($word) => strtoupper($word[0]))->take(2)->implode('') }}</div>
                </div>
            </div>
        </header>

        <aside data-mobile-menu class="fixed inset-y-0 left-0 z-40 hidden w-[248px] flex-col bg-[#12263a] px-5 py-6 lg:flex">
            <a href="{{ route('sales.dashboard') }}" class="flex items-center gap-3 px-2"><span class="grid h-9 w-9 place-items-center rounded-xl bg-[#f0b45a] text-xl font-bold text-[#12263a]">V</span><span class="font-display text-lg font-semibold tracking-tight text-white">vendor<span class="text-[#f0b45a]">flow</span></span></a>
            <p class="mt-12 px-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#6f879a]">Workspace</p>
            <nav class="mt-3 space-y-1">
                <a href="{{ route('sales.dashboard') }}" class="{{ request()->routeIs('sales.dashboard') ? 'bg-[#1b3a52] text-white' : 'text-[#aabccc]' }} block rounded-xl px-3 py-2.5 text-sm font-medium hover:bg-[#1b3a52] hover:text-white">Dashboard</a>
                <a href="{{ route('sales.vendors.index') }}" class="{{ request()->routeIs('sales.vendors.*') ? 'bg-[#1b3a52] text-white' : 'text-[#aabccc]' }} flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium hover:bg-[#1b3a52] hover:text-white"><span>Vendors</span><span class="rounded-full bg-[#f0b45a] px-1.5 py-0.5 text-[10px] font-bold text-[#12263a]">{{ \App\Models\Client::count() }}</span></a>
                <a href="#" class="block rounded-xl px-3 py-2.5 text-sm font-medium text-[#aabccc] hover:bg-[#1b3a52] hover:text-white">Leads</a>
                <a href="#" class="block rounded-xl px-3 py-2.5 text-sm font-medium text-[#aabccc] hover:bg-[#1b3a52] hover:text-white">Reports</a>
            </nav>
            <p class="mt-8 px-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#6f879a]">Manage</p>
            <nav class="mt-3 space-y-1"><a href="#" class="block rounded-xl px-3 py-2.5 text-sm font-medium text-[#aabccc] hover:bg-[#1b3a52] hover:text-white">Team</a><a href="#" class="block rounded-xl px-3 py-2.5 text-sm font-medium text-[#aabccc] hover:bg-[#1b3a52] hover:text-white">Settings</a></nav>
            <div class="mt-auto rounded-2xl border border-[#29465c] bg-[#1b3a52] p-4"><p class="text-xs font-semibold text-white">Network health</p><p class="mt-3 font-display text-2xl font-semibold text-white">92<span class="text-sm text-[#aabccc]">/100</span></p><div class="mt-3 h-1.5 rounded-full bg-[#29465c]"><div class="h-1.5 w-[92%] rounded-full bg-[#f0b45a]"></div></div><p class="mt-2 text-[10px] text-[#aabccc]">Healthy · reviewed today</p></div>
            <form method="POST" action="{{ route('logout') }}" class="mt-4">@csrf<button class="w-full rounded-xl px-3 py-2 text-left text-sm font-medium text-[#aabccc] hover:bg-[#1b3a52] hover:text-white">Log out</button></form>
        </aside>

        <main class="min-h-screen pt-[68px] lg:pl-[248px]">
            <div class="mx-auto max-w-[1500px] p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div data-dismiss class="mb-5 flex items-center justify-between rounded-xl border border-[#b9dbc8] bg-[#f1fbf5] px-4 py-3 text-sm font-medium text-[#26734b]"><span>{{ session('success') }}</span><button aria-label="Dismiss">×</button></div>
                @endif
                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-[#efc4bf] bg-[#fff5f3] px-4 py-3 text-sm text-[#a14f47]"><p class="font-semibold">Please check the highlighted details.</p><ul class="mt-1 list-inside list-disc text-xs">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>