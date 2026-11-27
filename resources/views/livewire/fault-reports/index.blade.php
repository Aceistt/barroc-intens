<section class="w-full space-y-6">
    <div>
        <nav class="text-sm text-slate-500" aria-label="Kruimelpad">
            {{ __('Maintenance') }} <span class="mx-2">/</span> <span class="text-slate-900">{{ __('Storingen') }}</span>
        </nav>
        <flux:heading size="xl" level="1" class="mt-3">{{ __('Storingen') }}</flux:heading>
        <flux:text class="mt-1">{{ __('Meldingen van defecte machines en opvolging.') }}</flux:text>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($stats as $stat)
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-2 text-3xl font-bold text-brand-black">{{ $stat['value'] }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ $stat['caption'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-4 md:grid-cols-[2fr_1fr_1fr]">
        <flux:input wire:model.live.debounce.300ms="search" :label="__('Zoeken')" :placeholder="__('Nummer, klant of machine')" icon="magnifying-glass" />

        <flux:select wire:model.live="priority" :label="__('Prioriteit')">
            <flux:select.option value="">{{ __('Alle prioriteiten') }}</flux:select.option>
            @foreach (\App\Models\FaultReport::PRIORITIES as $value => $label)
                <flux:select.option :value="$value">{{ $label }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:select wire:model.live="status" :label="__('Status')">
            <flux:select.option value="">{{ __('Alle statussen') }}</flux:select.option>
            @foreach (\App\Models\FaultReport::STATUSES as $value => $label)
                <flux:select.option :value="$value">{{ $label }}</flux:select.option>
            @endforeach
        </flux:select>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-5">
        <flux:heading size="lg" level="2">{{ __('Overzicht') }}</flux:heading>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 text-xs font-semibold text-slate-500">
                    <tr>
                        <th class="px-3 py-3">{{ __('Nummer') }}</th>
                        <th class="px-3 py-3">{{ __('Klant') }}</th>
                        <th class="px-3 py-3">{{ __('Machine') }}</th>
                        <th class="px-3 py-3">{{ __('Omschrijving') }}</th>
                        <th class="px-3 py-3">{{ __('Prioriteit') }}</th>
                        <th class="px-3 py-3">{{ __('Status') }}</th>
                        <th class="px-3 py-3">{{ __('Gemeld op') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($faultReports as $faultReport)
                        <tr wire:key="fault-report-{{ $faultReport->id }}">
                            <td class="px-3 py-3 font-medium text-slate-900">{{ $faultReport->number() }}</td>
                            <td class="px-3 py-3">{{ $faultReport->customer->company_name }}</td>
                            <td class="px-3 py-3">{{ $faultReport->machine ?? '–' }}</td>
                            <td class="max-w-xs truncate px-3 py-3" title="{{ $faultReport->description }}">{{ $faultReport->description }}</td>
                            <td class="px-3 py-3">
                                <span @class([
                                    'rounded-full px-2 py-0.5 text-xs font-medium',
                                    'bg-red-100 text-red-700' => $faultReport->priority === 'urgent',
                                    'bg-orange-100 text-orange-700' => $faultReport->priority === 'hoog',
                                    'bg-slate-100 text-slate-700' => ! in_array($faultReport->priority, ['urgent', 'hoog'], true),
                                ])>{{ $faultReport->priorityLabel() }}</span>
                            </td>
                            <td class="px-3 py-3">{{ $faultReport->statusLabel() }}</td>
                            <td class="px-3 py-3 text-slate-500">{{ $faultReport->created_at?->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 py-8 text-center text-slate-500">{{ __('Geen storingen gevonden.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $faultReports->links() }}
        </div>
    </div>
</section>
