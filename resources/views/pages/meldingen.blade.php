<x-layouts::app :title="__('Meldingen')">
    <section class="w-full space-y-6">
        <x-page-header :title="__('Meldingen')" :description="__('Bekijk updates die relevant zijn voor jouw rol.')" />

        <x-coming-soon :heading="__('Ongelezen meldingen')">
            {{ __('Hier komen meldingen zoals nieuwe storingen, geaccepteerde offertes en verzonden inkooporders.') }}
        </x-coming-soon>
    </section>
</x-layouts::app>
