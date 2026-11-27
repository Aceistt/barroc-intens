<x-layouts::app :title="__('Berichten')">
    <section class="w-full space-y-6">
        <x-page-header :title="__('Interne berichten')" :description="__('Werkcommunicatie per team en onderwerp.')" />

        <x-coming-soon :heading="__('Gesprekken')">
            {{ __('Hier komen de gesprekken per afdeling, zodat teams onderling berichten kunnen sturen.') }}
        </x-coming-soon>
    </section>
</x-layouts::app>
