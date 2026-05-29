@props(['currentStep' => 'personal'])

<div class="border border-gray-200 rounded-lg p-5 sticky top-20">
    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">
       Name :
    </h3>

    {{-- Step List --}}
    @php
        $steps = [
           
            ['key' => 'personal',  'label' => 'Personal Details', 'route' => 'user.personal.details'],
            ['key' => 'service', 'label' => 'Service',        'route' => 'user.service.index'],
            // ['key' => 'doctor', 'label' => 'Doctor',        'route' => 'user.doctor.index'],
            ['key' => 'vouchers', 'label' => 'Vouchers',        'route' => 'user.vouchers.index'],
             
        ];
    @endphp

    <ul class="space-y-2">
        @foreach($steps as $step)
            @php $isCurrent = $step['key'] === $currentStep; @endphp

            <li>
                <a href="{{ route($step['route']) }}"
                   class="flex items-center gap-3 p-2 rounded-lg transition hover:bg-gray-50
                          {{ $isCurrent ? 'bg-blue-50' : '' }}">

                    {{-- Step Circle --}}
                    <div class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center
                                {{ $isCurrent ? 'bg-green-100 border-2 border-green-500' : 'bg-gray-200 border-2 border-gray-300' }}">
                        @if($isCurrent)
                            <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                        @endif
                    </div>

                    {{-- Label --}}
                    <span class="flex-1 text-sm font-medium
                                 {{ $isCurrent ? 'text-blue-600' : 'text-gray-700' }}">
                        {{ $step['label'] }}
                    </span>

                    {{-- Arrow for current --}}
                    @if($isCurrent)
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>