{{-- resources/views/partials/biz-icon.blade.php --}}
{{-- Usage: @include('partials.biz-icon', ['icon' => 'users', 'color' => 'text-blue-600']) --}}
@php $cls = ($color ?? 'text-blue-600') . ' w-4 h-4'; @endphp

@switch($icon ?? '')
    @case('users')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
        </svg>
        @break
    @case('building')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        @break
    @case('bag')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 01-8 0"/>
        </svg>
        @break
    @case('target')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
        </svg>
        @break
    @case('globe')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="2" y1="12" x2="22" y2="12"/>
            <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10A15.3 15.3 0 0112 2z"/>
        </svg>
        @break
    @case('chart')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="20" x2="18" y2="10"/>
            <line x1="12" y1="20" x2="12" y2="4"/>
            <line x1="6"  y1="20" x2="6"  y2="14"/>
        </svg>
        @break
    @case('trending')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
            <polyline points="17 6 23 6 23 12"/>
        </svg>
        @break
    @case('dollar')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="1" x2="12" y2="23"/>
            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
        </svg>
        @break
    @case('headset')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M3 18v-6a9 9 0 0118 0v6"/>
            <path d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z"/>
        </svg>
        @break
    @case('shield')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        @break
    @default
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
        </svg>
@endswitch