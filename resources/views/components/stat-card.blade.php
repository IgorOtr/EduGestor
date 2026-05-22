@props(['value', 'label', 'color' => 'blue', 'icon' => null, 'route' => null])

<div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($value) }}</p>
        </div>
        @if($icon)
        <div class="w-14 h-14 rounded-2xl bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 flex items-center justify-center">
            {!! $icon !!}
        </div>
        @endif
    </div>
    @if($route)
    <a href="{{ $route }}" class="mt-4 flex items-center gap-1 text-xs text-{{ $color }}-600 font-medium hover:underline">
        Ver todos
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
    @endif
</div>
