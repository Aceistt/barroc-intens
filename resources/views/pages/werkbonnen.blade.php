<x-layouts::app :title="__('Werkbonnen')">
    <section class="w-full space-y-6">
        <x-page-header :title="__('Werkbonnen')" :description="__('Registreer werkzaamheden, onderdelen en resultaat.')" />

        <x-coming-soon :heading="__('Overzicht')">
            {{ __('Hier komen de werkbonnen van monteurs, met status, gebruikte onderdelen en handtekening van de klant.') }}
        </x-coming-soon>
    </section>
</x-layouts::app>
