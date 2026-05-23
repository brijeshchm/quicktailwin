 

@php
    
    $name         = 'Glamour Studio';
    $timezone     = 'Asia/Kolkata';
    $tz_label     = 'IST';          // shown next to the live clock
    $phone        = '+91 98765 12345';
    $phone_dial   = '+919876512345'; // for tel: links (no spaces)
    $whatsapp     = '919876512345';  // for https://wa.me/ links
    $email        = 'hello@glamourstudio.in';
    $address      = "18 FC Road, Near Goodluck Café,\nShivaji Nagar, Pune – 411005";
    $map_query    = 'FC Road Shivaji Nagar Pune';  // used in Google Maps embed URL
 
    $hours = [
        ['label' => 'Mon – Fri', 'time' => '9:00 AM – 8:00 PM', 'open' => 9,  'close' => 20, 'days' => [1, 2, 3, 4, 5]],
        ['label' => 'Saturday',  'time' => '8:00 AM – 9:00 PM', 'open' => 8,  'close' => 21, 'days' => [6]],
        ['label' => 'Sunday',    'time' => '10:00 AM – 7:00 PM','open' => 10, 'close' => 19, 'days' => [0]],
    ];

    /*
    |--------------------------------------------------------------------------
    | Social handles
    |--------------------------------------------------------------------------
    */
    $social = [
        ['platform' => 'Instagram', 'name' => '@glamourstudiopune',  'icon' => '📸', 'followers' => '24.8K followers',     'handle' => 'glamourstudiopune', 'url' => 'https://instagram.com/glamourstudiopune'],
        ['platform' => 'Facebook',  'name' => 'Glamour Studio Pune', 'icon' => '👥', 'followers' => '12.4K likes',         'handle' => 'glamourstudiopune', 'url' => 'https://facebook.com/glamourstudiopune'],
        ['platform' => 'YouTube',   'name' => '@GlamourStudioPune',  'icon' => '▶️', 'followers' => '8.9K subscribers',    'handle' => 'glamourstudiopune', 'url' => 'https://youtube.com/glamourstudiopune'],
    ];

    /*
    |--------------------------------------------------------------------------
    | "Why Choose Us" tags
    |--------------------------------------------------------------------------
    */
    $tags = [
        '🏆 Award Winning',
        '🎓 Expert Stylists',
        '🌿 Cruelty-Free',
        '✨ Premium Brands',
        '🧴 Hygienic',
        '💯 Satisfaction Guaranteed',
    ];


    $hours        = rowsWithToday();
    $isOpenNow    = isOpen();
    $initialTime  = now();
   

    // Pre-encode hours for the client-side ticker
    $hoursForJs = array_map(fn($r) => [
        'open'  => $r['open'],
        'close' => $r['close'],
        'days'  => $r['days'],
    ], $hours);

    $mapEmbed = 'https://maps.google.com/maps?q=' . urlencode($map_query) . '&output=embed';
@endphp

<section
    class="mx-auto max-w-7xl px-6 py-20"
    x-data="salonBusinessInfo({
        hours:        {{ Js::from($hoursForJs) }},
        initialOpen:  {{ $isOpenNow ? 'true' : 'false' }},
        initialDow:   {{ (int) now($timezone)->dayOfWeek }},
        initialTime:  {{ Js::from($initialTime) }},
        tzLabel:      {{ Js::from($tz_label) }},
        tzOffsetMin:  {{ now($timezone)->utcOffset() }},
    })"
    x-init="startTicker()"
>
     
 
</section>

{{-- ═══════════════════════════════════════════════════════════
     ALPINE COMPONENT LOGIC
═══════════════════════════════════════════════════════════ --}}
<script>
    function salonBusinessInfo({ hours, initialOpen, initialDow, initialTime, tzLabel, tzOffsetMin }) {
        return {
            hours,
            isOpen:     initialOpen,
            todayDow:   initialDow,
            timeLabel:  initialTime,
            tzLabel,
            tzOffsetMin,

            /* Current time in the business's timezone (not the user's) */
            businessNow() {
                const now        = new Date();
                const userOffset = -now.getTimezoneOffset();   // user TZ offset in minutes
                const diff       = this.tzOffsetMin - userOffset;
                return new Date(now.getTime() + diff * 60 * 1000);
            },

            recalc() {
                const now = this.businessNow();
                this.todayDow  = now.getDay();
                const h = now.getHours();

                const row = this.hours.find(r => r.days.includes(this.todayDow));
                this.isOpen = !!row && h >= row.open && h < row.close;

                const hh = String(now.getHours()).padStart(2, '0');
                const mm = String(now.getMinutes()).padStart(2, '0');
                this.timeLabel = `${hh}:${mm} ${this.tzLabel}`;
            },

            isToday(daysArray) {
                if (!Array.isArray(daysArray) || daysArray.length === 0) return false;
                return daysArray.includes(this.todayDow);
            },

            /* Re-check every minute so the badge + clock stay accurate */
            startTicker() {
                this.recalc();   // immediate first pass to sync clock seconds
                setInterval(() => this.recalc(), 60 * 1000);
            },
        };
    }
</script>