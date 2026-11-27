<x-layouts::app :title="__('Betalingen')">
    <section class="w-full space-y-6">
        <x-page-header :title="__('Betalingen')" :description="__('Registreer ontvangen bedragen en koppel facturen.')" />

        <x-coming-soon :heading="__('Overzicht')">
            {{ __('Hier komen de ontvangen betalingen met datum, factuur, klant, bedrag en betaalmethode.') }}
        </x-coming-soon>
    </section>
</x-layouts::app>
