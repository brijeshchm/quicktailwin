@props(['value' => 0, 'label' => '', 'prefix' => '', 'suffix' => ''])

<div x-data="{
        current: 0,
        target: {{ (int) $value }},
        animate() {
            const duration = 2000;
            const step = this.target / (duration / 16);
            const t = setInterval(() => {
                this.current += step;
                if (this.current >= this.target) { this.current = this.target; clearInterval(t); }
            }, 16);
        }
     }"
     x-intersect.once="animate()"
     class="flex flex-col items-center text-center">

    <div class="text-4xl md:text-5xl font-bold text-primary mb-2">
        {{ $prefix }}<span x-text="Math.floor(current)">0</span>{{ $suffix }}
    </div>
    <div class="text-sm md:text-base text-muted-foreground font-medium uppercase tracking-wider">
        {{ $label }}
    </div>
</div>