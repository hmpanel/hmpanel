@props([
    'bodyClasses' => 'bg-white rounded-lg shadow overflow-hidden',
])

<div {{ $attributes->merge(['class' => '']) }}>
    <div class="{{ $bodyClasses }}">

        @if(isset($title))
        <h4 class="text-lg font-bold mb-3">
            {{ $title }}
        </h4>
        @endif

        @if(isset($subtitle))
        <h5 class="text-gray-600 text-sm">
            {{ $subtitle }}
        </h5>
        @endif

        {{ $slot }}
    </div>
</div>
