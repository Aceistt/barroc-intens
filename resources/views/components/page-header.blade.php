@props([
    'title',
    'description' => null,
])

<div>
    <nav class="text-sm text-slate-500" aria-label="Kruimelpad">
        {{ auth()->user()?->role?->name }} <span class="mx-2">/</span> <span class="text-slate-900">{{ $title }}</span>
    </nav>
    <flux:heading size="xl" level="1" class="mt-3">{{ $title }}</flux:heading>
    @if ($description)
        <flux:text class="mt-1">{{ $description }}</flux:text>
    @endif
</div>
