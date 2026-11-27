@props([
    'heading',
])

<div class="rounded-xl border border-slate-200 bg-white p-5">
    <flux:heading size="lg" level="2">{{ $heading }}</flux:heading>

    <div class="mt-4 rounded-lg border border-dashed border-brand-yellow bg-brand-yellow-light px-4 py-10 text-center">
        <p class="font-semibold text-brand-black">{{ __('Deze pagina is nog in ontwikkeling.') }}</p>
        <p class="mt-1 text-sm text-slate-600">{{ $slot }}</p>
    </div>
</div>
