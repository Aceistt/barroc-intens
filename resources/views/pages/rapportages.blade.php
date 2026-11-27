<x-layouts::app :title="__('Rapportages')">
    <section class="w-full space-y-6">
        <x-page-header :title="__('Rapportages')" :description="__('Vergelijk cijfers per periode en afdeling.')" />

        <x-coming-soon :heading="__('Omzet en werkverdeling')">
            {{ __('Hier komen de omzet per maand en per jaar, openstaande facturen, nieuwe orders en open storingen.') }}
        </x-coming-soon>
    </section>
</x-layouts::app>
