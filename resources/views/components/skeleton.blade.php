@props([
    'width' => 'w-full',
    'height' => 'h-4',
    'rounded' => 'rounded',
    'class' => '',
])

<div class="skeleton {{ $width }} {{ $height }} {{ $rounded }} {{ $class }}"></div>
