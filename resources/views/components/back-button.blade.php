@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'global-back-button']) }}>Regresar</a>
