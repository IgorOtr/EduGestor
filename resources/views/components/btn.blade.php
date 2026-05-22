@props(['href', 'variant' => 'primary', 'size' => 'md'])

@php
$classes = match($variant) {
    'primary'   => 'bg-blue-600 hover:bg-blue-700 text-white',
    'secondary' => 'bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200',
    'danger'    => 'bg-red-600 hover:bg-red-700 text-white',
    'success'   => 'bg-green-600 hover:bg-green-700 text-white',
    'outline'   => 'border border-gray-300 hover:bg-gray-50 text-gray-700',
    default     => 'bg-blue-600 hover:bg-blue-700 text-white',
};
$sizeClasses = match($size) {
    'sm'  => 'px-3 py-1.5 text-xs',
    'md'  => 'px-4 py-2 text-sm',
    'lg'  => 'px-6 py-2.5 text-base',
    default => 'px-4 py-2 text-sm',
};
@endphp

@if(isset($href))
<a href="{{ $href }}" {{ $attributes->merge(['class' => "inline-flex items-center gap-2 font-medium rounded-xl transition duration-200 {$classes} {$sizeClasses}"]) }}>
    {{ $slot }}
</a>
@else
<button {{ $attributes->merge(['class' => "inline-flex items-center gap-2 font-medium rounded-xl transition duration-200 {$classes} {$sizeClasses}"]) }}>
    {{ $slot }}
</button>
@endif
