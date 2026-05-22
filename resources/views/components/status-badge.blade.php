@props(['status'])

@php
$color = match($status->value ?? $status) {
    'aprovado'             => 'green',
    'parcialmente_aprovado'=> 'blue',
    'recusado'             => 'red',
    'pendente'             => 'yellow',
    default                => 'gray',
};
$label = method_exists($status, 'label') ? $status->label() : ucfirst($status);
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-{{ $color }}-100 text-{{ $color }}-800 dark:bg-{{ $color }}-900/30 dark:text-{{ $color }}-300">
    {{ $label }}
</span>
