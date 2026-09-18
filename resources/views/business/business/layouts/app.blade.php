<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · QuickDials</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: {
            colors: {
                background:'hsl(var(--background) / <alpha-value>)', foreground:'hsl(var(--foreground) / <alpha-value>)',
                card:'hsl(var(--card) / <alpha-value>)', border:'hsl(var(--border) / <alpha-value>)', input:'hsl(var(--input) / <alpha-value>)', ring:'hsl(var(--ring) / <alpha-value>)',
                primary:'hsl(var(--primary) / <alpha-value>)', secondary:'hsl(var(--secondary) / <alpha-value>)', muted:'hsl(var(--muted) / <alpha-value>)',
                accent:'hsl(var(--accent) / <alpha-value>)', destructive:'hsl(var(--destructive) / <alpha-value>)'
            },
            fontFamily:{sans:['Plus Jakarta Sans','sans-serif'],display:['Outfit','sans-serif']},
            borderRadius:{xl:'1rem','2xl':'1.25rem'}, boxShadow:{card:'0 8px 30px rgba(15,23,42,.06)'}
        }}}
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
    <style>
        :root{--background:210 20% 98%;--foreground:222 47% 11%;--card:0 0% 100%;--border:214 32% 91%;--input:214 32% 91%;--ring:230 90% 55%;--primary:230 90% 55%;--secondary:210 40% 96%;--muted:210 40% 96%;--accent:24 95% 53%;--destructive:0 84% 60%}
        [x-cloak]{display:none!important} *{border-color:hsl(var(--border))} html{scroll-behavior:smooth} body{margin:0;background:hsl(var(--background));color:hsl(var(--foreground));font-family:'Plus Jakarta Sans',sans-serif;-webkit-font-smoothing:antialiased;overflow-x:hidden} h1,h2,h3,h4,h5,h6{font-family:'Outfit',sans-serif;letter-spacing:-.02em}
        .glass-nav{background:rgba(255,255,255,.88);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px)} .hide-scrollbar{-ms-overflow-style:none;scrollbar-width:none}.hide-scrollbar::-webkit-scrollbar{display:none}.pb-safe{padding-bottom:max(.5rem,env(safe-area-inset-bottom))}
        .animate-fade-in{animation:fadeIn .35s ease-out both}.animate-slide-up{animation:slideUp .5s cubic-bezier(.16,1,.3,1) both}.stagger-1{animation-delay:.05s}.stagger-2{animation-delay:.1s}.stagger-3{animation-delay:.15s}.stagger-4{animation-delay:.2s}.stagger-5{animation-delay:.25s}@keyframes fadeIn{from{opacity:0}to{opacity:1}}@keyframes slideUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
        .form-input{width:100%;height:2.75rem;border:1px solid hsl(var(--input));border-radius:.75rem;background:transparent;padding:.5rem .9rem;font-size:.875rem;outline:none;transition:.2s}.form-input:focus{box-shadow:0 0 0 3px hsl(var(--ring)/.14);border-color:hsl(var(--ring))}.form-textarea{min-height:7rem;height:auto;resize:vertical;padding-top:.75rem}.btn{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;white-space:nowrap;border-radius:.75rem;font-weight:600;font-size:.875rem;height:2.5rem;padding:0 1rem;transition:.18s;cursor:pointer}.btn:active{transform:scale(.98)}.btn-primary{background:hsl(var(--primary));color:white;box-shadow:0 8px 20px hsl(var(--primary)/.18)}.btn-primary:hover{filter:brightness(.96)}.btn-outline{border:1px solid hsl(var(--border));background:white}.btn-outline:hover,.btn-ghost:hover{background:hsl(var(--secondary))}.btn-ghost{background:transparent}.btn-danger{background:hsl(var(--destructive)/.1);color:hsl(var(--destructive))}.card{background:white;border-radius:1rem;box-shadow:0 8px 30px rgba(15,23,42,.06)}.badge{display:inline-flex;align-items:center;gap:.3rem;border-radius:999px;padding:.25rem .6rem;font-size:.72rem;font-weight:700}.icon-sm{width:1rem;height:1rem}.icon-md{width:1.25rem;height:1.25rem}.icon-lg{width:1.5rem;height:1.5rem}
        @supports(padding-bottom:env(safe-area-inset-bottom)){.pb-safe{padding-bottom:env(safe-area-inset-bottom)}}

        .help-block{
            color: #ff0000;
    position: relative;   
    display: block;
  
        }
    </style>
    @stack('head')
</head>
@php
$nav=[
 ['route'=>'dashboard','label'=>'Dashboard','icon'=>'layout-dashboard','path'=>'/business/dashboard'],
  
 ['route'=>'followups','label'=>'Follow-ups','icon'=>'calendar-check','path'=>'/follow-ups'],
 
 ];

$navOther=[
  
 //['route'=>'listings','label'=>'Listings','icon'=>'list','path'=>'/listings'],
 ['route'=>'reviews','label'=>'Reviews','icon'=>'star','path'=>'/reviews'],
 ['route'=>'pending-profile','label'=>'Pending Profile','icon'=>'users','path'=>'/pending-profile'],
 
//  ['route'=>'team','label'=>'Team','icon'=>'users','path'=>'/team']
 ];


$profileTabs=['general'=>'Basic Info','personal'=>'Personal Details','seo'=>'SEO Meta','keywords'=>'Service Keywords','locations'=>'Service Areas','media'=>'Media & Gallery','awards'=>'Awards','certs'=>'Certificates','socials'=>'Social Links','recent'=>'Recent Activity','faqs'=>'FAQ`s'];

$leadsTabs=['leads'=>'Lead','new-lead'=>'New Leads','favorites'=>'Favorites','archived'=>'Archived','manage-enquiry'=>'Manage Enquiry'];


$accountTabs=['settings'=>'Account Settings','package'=>'Package','invoices'=>'Invoice History','coins_history'=>'Coins History','transactions'=>'Transactions'];

$pageName=request()->is('profile*')?'Profile':(request()->is('account*')?'Account':collect(array_merge($nav,[['route'=>'contact','label'=>'Contact'],['route'=>'team','label'=>'Team']]))->first(fn($n)=>request()->routeIs($n['route']??''))['label']??'Dashboard');

 
@endphp
<body x-data="{profileOpen:{{ request()->is('business/profile*')?'true':'false' }},accountOpen:{{ request()->is('business/account*')?'true':'false' }},leadsOpen:{{ request()->is('business/leads*')?'true':'false' }}}">
<div class="flex min-h-[100dvh] w-full flex-col bg-background md:flex-row">
    <aside class="fixed inset-y-0 z-20 hidden w-64 flex-col border-r bg-card shadow-sm md:flex">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-6"><span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary font-display text-lg font-bold text-white">Q</span><span class="font-display text-xl font-bold tracking-tight">QuickDials</span></a>
        <div class="px-4 pb-4"><div class="rounded-xl border bg-secondary/50 p-4"><h3 class="truncate text-sm font-semibold">{{ $profile['name'] }}</h3><p class="truncate text-xs text-slate-500">{{ $profile['category'] }}</p><form action="{{ route('signout') }}" method="POST">@csrf<button class="mt-3 flex w-full items-center justify-center gap-2 rounded-lg bg-destructive/10 px-3 py-2 text-xs font-semibold text-destructive hover:bg-destructive/20"><i data-lucide="log-out" class="h-3.5 w-3.5"></i> Sign out</button></form></div></div>
        <nav class="hide-scrollbar flex-1 space-y-1 overflow-y-auto px-4 pb-5">                 
        @foreach($nav as $item)
                <a href="{{ route($item['route']) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs($item['route'])?'bg-primary text-white shadow-md shadow-primary/20':'text-slate-500 hover:bg-secondary hover:text-foreground' }}"><i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i>{{ $item['label'] }}</a>
        @endforeach
            <div>                
                <button @click="leadsOpen=!leadsOpen" type="button" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->is('business/leads*')?'bg-primary text-white shadow-md shadow-primary/20':'text-slate-500 hover:bg-secondary hover:text-foreground' }}"><i data-lucide="message-square-text" class="h-5 w-5"></i>Leads<i data-lucide="chevron-down" class="ml-auto h-4 w-4 transition" :class="leadsOpen&&'rotate-180'"></i></button>
                <div x-show="leadsOpen" class="ml-4 mt-1 space-y-0.5 border-l pl-4">
                    
                @foreach($leadsTabs as $leadkey=>$Leadlabel)
                
                <a href="{{ route('leads',['tab'=>$leadkey]) }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->route('tab','leads')===$leadkey &&request()->is('business/leads*')?'bg-primary/10 font-semibold text-primary':'text-slate-500 hover:bg-secondary hover:text-foreground' }}">{{ $Leadlabel }}</a>
                
                @endforeach
            
            
            </div>


            </div>



            <div>
                
                <button @click="profileOpen=!profileOpen" type="button" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->is('business/profile*')?'bg-primary text-white shadow-md shadow-primary/20':'text-slate-500 hover:bg-secondary hover:text-foreground' }}"><i data-lucide="user" class="h-5 w-5"></i>Profile<i data-lucide="chevron-down" class="ml-auto h-4 w-4 transition" :class="profileOpen&&'rotate-180'"></i></button>
                <div x-show="profileOpen" class="ml-4 mt-1 space-y-0.5 border-l pl-4">
                    
                @foreach($profileTabs as $key=>$label)
                
                <a href="{{ route('profile',['tab'=>$key]) }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->route('tab','general')===$key &&request()->is('business/profile*')?'bg-primary/10 font-semibold text-primary':'text-slate-500 hover:bg-secondary hover:text-foreground' }}">{{ $label }}</a>
                
                @endforeach
            
            
            </div>


            </div>


            <div>
                <button @click="accountOpen=!accountOpen" type="button" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->is('business/account*')?'bg-primary text-white shadow-md shadow-primary/20':'text-slate-500 hover:bg-secondary hover:text-foreground' }}"><i data-lucide="wallet" class="h-5 w-5"></i>Account<i data-lucide="chevron-down" class="ml-auto h-4 w-4 transition" :class="accountOpen&&'rotate-180'"></i></button>

                <div x-show="accountOpen" class="ml-4 mt-1 space-y-0.5 border-l pl-4">
                    
                @foreach($accountTabs as $key=>$label)<a href="{{ route('account',['tab'=>$key]) }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->route('tab','settings')===$key&&request()->is('business/account*')?'bg-primary/10 font-semibold text-primary':'text-slate-500 hover:bg-secondary hover:text-foreground' }}">{{ $label }}</a>
                @endforeach
            
            </div>
            </div>


             @foreach($navOther as $item)
                <a href="{{ route($item['route']) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs($item['route'])?'bg-primary text-white shadow-md shadow-primary/20':'text-slate-500 hover:bg-secondary hover:text-foreground' }}"><i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i>{{ $item['label'] }}</a>
            @endforeach


            <a href="{{ route('contact') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('contact')?'bg-primary text-white shadow-md shadow-primary/20':'text-slate-500 hover:bg-secondary hover:text-foreground' }}"><i data-lucide="headset" class="h-5 w-5"></i>Contact</a>
        </nav>
    </aside>
    <main class="relative flex min-h-[100dvh] w-full flex-1 flex-col pb-[calc(5.5rem+env(safe-area-inset-bottom))] md:pl-64 md:pb-0">
        <header class="glass-nav top-0 z-30 flex flex-col gap-2 border-b px-4 py-2 md:hidden">
            <div class="flex items-center justify-between">
                
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2"><span class="flex h-7 w-7 items-center justify-center rounded-md bg-primary font-display text-sm font-bold text-white">Q</span><span class="font-display text-lg font-bold">QuickDials</span></a>
           <div class="flex items-center gap-2">
              
@php
     
    $percent = $profile['profileCompletion'];
    $color = $percent >= 80 ? 'emerald' : ($percent >= 50 ? 'amber' : 'destructive');
@endphp

<div class="p-4">
    <div class="mb-2 flex items-center justify-between">
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
            Completion
        </p>
        <span class="font-display text-lg font-bold text-{{ $color }}-600">
            {{ round($percent) }}%
        </span>
    </div>

    <div class="h-2 w-full overflow-hidden rounded-full bg-secondary">
        <div class="h-full rounded-full bg-{{ $color }}-500 transition-all duration-500"
             style="width: {{ round($percent) }}%"></div>
    </div>

    
</div>

            
            <a href="{{ route('account') }}" class="flex items-center gap-1.5 rounded-lg border bg-secondary/80 px-2.5 py-1.5 text-sm font-semibold"><i data-lucide="coins" class="h-4 w-4 text-accent"></i>{{ number_format($account['coins']) }}</a><button class="relative flex h-8 w-8 items-center justify-center rounded-full bg-secondary"><i data-lucide="bell" class="h-4 w-4"></i><span class="absolute right-0 top-0 h-2.5 w-2.5 rounded-full border-2 border-background bg-accent"></span></button></div>
        
        
        </div>


   


            @if(request()->routeIs('leads'))
            
            <form action="{{ route('pause.lead') }}" method="POST" class="flex items-center justify-between rounded-xl border border-primary/10 bg-primary/5 px-3 py-2">
                
            @csrf 
                      
            
            <input type="hidden" name="pauseLead" value="{{ $account['pauseLead']?0:1 }}">
            
            <div class="flex items-center gap-2">
                
            <span class="h-2 w-2 rounded-full {{ $account['pauseLead']?'bg-destructive':'animate-pulse bg-emerald-500' }}"></span>
            
            <span class="text-xs font-semibold">{{ $account['pauseLead']?'Leads Paused':'Receiving Leads' }}</span></div>
            
            <button class="relative h-6 w-11 rounded-full {{ $account['pauseLead']?'bg-slate-300':'bg-primary' }}">
                
            <span class="absolute top-1 h-4 w-4 rounded-full bg-white transition {{ $account['pauseLead']?'left-1':'left-6' }}">
            </span>
        
        </button>
        
        </form>
        
        @endif
        </header>
        <header class="top-0 z-10 hidden h-16 items-center justify-between border-b bg-background/80 px-8 backdrop-blur-md md:flex"><h1 class="font-display text-xl font-semibold">{{ $pageName }}</h1>
           

@php
     
    $percent = $profile['profileCompletion'];
    $color = $percent >= 80 ? 'emerald' : ($percent >= 50 ? 'amber' : 'destructive');
@endphp

<div class="p-4">
    <div class="mb-2 flex items-center justify-between">
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
            Profile Completion
        </p>
        <span class="font-display text-lg font-bold text-{{ $color }}-600">
            {{ round($percent) }}%
        </span>
    </div>

    <div class="h-2 w-full overflow-hidden rounded-full bg-secondary">
        <div class="h-full rounded-full bg-{{ $color }}-500 transition-all duration-500"
             style="width: {{ round($percent) }}%"></div>
    </div>

    
</div>
  <div>
    <a href="{{ route('leads',['tab'=>'new-lead']) }}"
       class="inline-flex bell items-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold transition hover:bg-blue-600">               
        <i data-lucide="mail" class="h-8 w-8"></i>
        <span class="rounded-full bg-green-500 px-2 py-0.5 bell text-xs font-bold text-white">
            {{ $profile['newLead'] ?? 0 }}
        </span>
    </a>
</div>

<style>
    .bell{ 
      animation: colorChange 3s infinite linear;
    }
    @keyframes colorChange {
      0%   { color: #ff0000; }   /* red */
      25%  { color: #FF671F; }   /* green */
      50%  { color: #ff0000; }   /* blue */
      75%  { color: #FDEE04; }   /* magenta */
      100% { color: #5AB70F; }   /* back to red */
    }
</style>
        <div class="flex items-center gap-6">
            
        
        <div class="flex items-center gap-3 rounded-xl border bg-secondary/50 px-3 py-1.5">
                  

        @if(request()->routeIs('leads'))
 
        <form
            id="pauseLeadForm"
            action="{{ route('pause.lead') }}"
            method="POST"
            class="flex items-center justify-between rounded-xl border border-primary/10 bg-primary/5 px-3 py-2"
        >

            @csrf

            <input
                type="hidden"
                name="pauseLead"
                id="pauseLeadValue"
                value="{{ $account['pauseLead'] ? 0 : 1 }}"
            >


            <div class="flex items-center gap-2">

                <span
                    id="pauseLeadDot"
                    class="h-2 w-2 rounded-full
                    {{ $account['pauseLead']
                        ? 'bg-red-500'
                        : 'animate-pulse bg-emerald-500'
                    }}"
                ></span>


                <span
                    id="pauseLeadText"
                    class="text-xs font-semibold"
                >
                    {{ $account['pauseLead']
                        ? 'Leads Paused'
                        : 'Receiving Leads'
                    }}
                </span>

            </div>


            <button
                type="submit"
                id="pauseLeadButton"
                class="relative h-6 w-11 rounded-full transition
                {{ $account['pauseLead']
                    ? 'bg-slate-300'
                    : 'bg-primary'
                }}"
            >

                <span
                    id="pauseLeadKnob"
                    class="absolute top-1 h-4 w-4 rounded-full bg-white transition-all
                    {{ $account['pauseLead']
                        ? 'left-1'
                        : 'left-6'
                    }}"
                ></span>

            </button>

        </form>

    @endif
        
        
        <a href="{{ route('account') }}" class="flex items-center gap-2"><i data-lucide="coins" class="h-5 w-5 text-accent"></i><span class="font-display font-bold">Remaining Cons:{{ number_format($account['coins']) }}</span></a>    
        </div>
        
    <button class="relative flex h-9 w-9 items-center justify-center rounded-full border bg-card text-slate-500 shadow-sm"><i data-lucide="bell" class="h-4 w-4"></i><span class="absolute right-0 top-0 h-2.5 w-2.5 rounded-full border-2 border-card bg-accent"></span></button>

    </div>

</header>
        <div class="mx-auto w-full max-w-6xl flex-1 p-3 md:p-8">@yield('content')</div>
    </main>
    <nav class="glass-nav pb-safe fixed inset-x-0 bottom-0 z-40 border-t md:hidden"><div class="hide-scrollbar flex items-center justify-around overflow-x-auto px-2 py-2">
        @foreach(array_merge($nav,[['route'=>'leads','label'=>'Leads','icon'=>'message-square-text'],['route'=>'profile','label'=>'Profile','icon'=>'user'],['route'=>'account','label'=>'Account','icon'=>'wallet'],['route'=>'contact','label'=>'Contact','icon'=>'headset']],$navOther) as $item)
        @php         
            $active = match ($item['route']) {
                'profile' => request()->is('business/profile*'),
                'account' => request()->is('business/account*'),
                'leads'   => request()->is('business/leads*'),
                default   => request()->routeIs($item['route']),
            };        
         @endphp
        <a href="{{ route($item['route']) }}" class="flex min-w-[56px] shrink-0 flex-col items-center gap-0.5 rounded-xl p-1.5 transition {{ $active?'text-primary':'text-slate-500' }}"><span class="flex h-7 w-7 items-center justify-center rounded-full {{ $active?'bg-primary/10':'' }}"><i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i></span><span class="text-[10px] font-medium">{{ $item['label'] }}</span></a>
        @endforeach
    </dkiv></nav>



</div>
@if(session('success'))<div x-data="{show:true}" x-init="setTimeout(()=>show=false,3500)" x-show="show" x-transition class="fixed right-4 top-20 z-50 flex max-w-sm items-start gap-3 rounded-xl border bg-white p-4 shadow-xl"><span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-emerald-600"><i data-lucide="check" class="h-5 w-5"></i></span><div><p class="text-sm font-semibold">Success</p><p class="text-xs text-slate-500">{{ session('success') }}</p></div><button @click="show=false"><i data-lucide="x" class="h-4 w-4 text-slate-400"></i></button></div>@endif
@if($errors->any())<div x-data="{show:true}" x-show="show" class="fixed right-4 top-20 z-50 max-w-sm rounded-xl border border-red-200 bg-white p-4 shadow-xl"><div class="flex gap-3"><i data-lucide="circle-alert" class="h-5 w-5 text-destructive"></i><div><p class="text-sm font-semibold">Please check the form</p>@foreach($errors->all() as $error)<p class="mt-1 text-xs text-slate-500">{{ $error }}</p>@endforeach</div><button @click="show=false"><i data-lucide="x" class="h-4 w-4"></i></button></div></div>@endif
<script>document.addEventListener('DOMContentLoaded',()=>lucide.createIcons());document.addEventListener('alpine:initialized',()=>setTimeout(()=>lucide.createIcons(),30));</script>
@stack('scripts')


<script>

document.addEventListener('DOMContentLoaded', function () {

    const form =
        document.getElementById('pauseLeadForm');

    if (!form) {
        return;
    }


    const valueInput =
        document.getElementById('pauseLeadValue');

    const button =
        document.getElementById('pauseLeadButton');

    const knob =
        document.getElementById('pauseLeadKnob');

    const dot =
        document.getElementById('pauseLeadDot');

    const text =
        document.getElementById('pauseLeadText');


    form.addEventListener('submit', async function (e) {

        e.preventDefault();

        if (button.disabled) {
            return;
        }

        button.disabled = true;
        button.classList.add('opacity-60');


        const formData =
            new FormData(form);


        try {

            const response =
                await fetch(form.action, {

                    method: 'POST',

                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },

                    body: formData

                });


            const data =
                await response.json();


            if (!response.ok) {
                throw data;
            }


            /*
            |--------------------------------------------------------------------------
            | Expect:
            | data.pauseLead = 1  => paused
            | data.pauseLead = 0  => active
            |--------------------------------------------------------------------------
            */

            const isPaused =
                Number(data.pauseLead) === 1;


            /*
            | Set next value
            */

            valueInput.value =
                isPaused ? 0 : 1;


            /*
            | Text
            */

            text.textContent =
                isPaused
                    ? 'Leads Paused'
                    : 'Receiving Leads';


            /*
            | Dot
            */

            dot.className =
                'h-2 w-2 rounded-full ' +
                (
                    isPaused
                        ? 'bg-red-500'
                        : 'animate-pulse bg-emerald-500'
                );


            /*
            | Toggle background
            */

            button.className =
                'relative h-6 w-11 rounded-full transition ' +
                (
                    isPaused
                        ? 'bg-slate-300'
                        : 'bg-primary'
                );


            /*
            | Toggle knob
            */

            knob.className =
                'absolute top-1 h-4 w-4 rounded-full bg-white transition-all ' +
                (
                    isPaused
                        ? 'left-1'
                        : 'left-6'
                );


            showToast(
                data.message ||
                (
                    isPaused
                        ? 'Leads paused successfully.'
                        : 'Leads resumed successfully.'
                ),
                'success'
            );

        }

        catch (error) {

            console.error(error);

            showToast(
                error.message ||
                'Unable to update lead status.',
                'error'
            );

        }

        finally {

            button.disabled = false;
            button.classList.remove('opacity-60');

        }

    });

});

</script>

</body></html>
