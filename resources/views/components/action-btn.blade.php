@props([
    'type'    => 'link',  // link | show | edit | delete
    'href'    => null,
    'method'  => 'DELETE',
    'confirm' => null,
    'title'   => null,
    'class'   => '',
])

@php
$icons = [
    'show'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>',
    'edit'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
    'delete' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>',
    'link'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>',
];

$colors = [
    'show'   => 'bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50',
    'edit'   => 'bg-yellow-50 text-yellow-600 hover:bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-900/50',
    'delete' => 'bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50',
    'link'   => 'bg-gray-50 text-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600',
];

$icon  = $icons[$type]  ?? $icons['link'];
$color = $colors[$type] ?? $colors['link'];
$titleAttr = $title ?? ucfirst($type);
@endphp

@if($type === 'delete')
<form method="POST" action="{{ $href }}"
      onsubmit="return confirm('{{ $confirm ?? 'Tem certeza?' }}')"
      class="inline">
    @csrf @method('DELETE')
    <button type="submit" title="{{ $titleAttr }}"
            class="inline-flex items-center justify-center p-2 rounded-lg shadow-sm border border-transparent transition-all duration-150 {{ $color }} {{ $class }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $icon !!}
        </svg>
    </button>
</form>
@else
<a href="{{ $href }}" title="{{ $titleAttr }}"
   class="inline-flex items-center justify-center p-2 rounded-lg shadow-sm border border-transparent transition-all duration-150 {{ $color }} {{ $class }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $icon !!}
    </svg>
</a>
@endif
