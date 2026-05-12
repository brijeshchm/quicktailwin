{{-- resources/views/partials/about-icon.blade.php --}}
{{-- Usage: @include('partials.about-icon', ['icon' => 'shield', 'color' => 'text-emerald-600']) --}}
@php $cls = ($color ?? 'text-gray-500') . ' w-5 h-5'; @endphp

@switch($icon ?? '')
    @case('phone')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012 .9h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.09a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 15z"/>
        </svg>
        @break
    @case('globe')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="2" y1="12" x2="22" y2="12"/>
            <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10A15.3 15.3 0 0112 2z"/>
        </svg>
        @break
    @case('trending')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
            <polyline points="17 6 23 6 23 12"/>
        </svg>
        @break
    @case('star')
        <svg class="{{ $cls }}" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>
        @break
    @case('zap')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
        </svg>
        @break
    @case('shield')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        @break
    @case('heart')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
        </svg>
        @break
    @case('users')
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
        </svg>
        @break
    @default
        <svg class="{{ $cls }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
        </svg>
@endswitch