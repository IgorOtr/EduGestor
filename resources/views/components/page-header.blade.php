@props(['title', 'description' => null, 'actions' => null])

<div class="mb-6 flex items-start justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
        @if($description)
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $description }}</p>
        @endif
    </div>
    @if($actions)
    <div class="flex items-center gap-2 flex-shrink-0">
        {{ $actions }}
    </div>
    @endif
</div>
