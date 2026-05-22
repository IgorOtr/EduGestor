@props(['title' => null, 'padding' => true])

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    @if($title)
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white">{{ $title }}</h3>
    </div>
    @endif
    <div class="{{ $padding ? 'p-6' : '' }}">
        {{ $slot }}
    </div>
</div>
