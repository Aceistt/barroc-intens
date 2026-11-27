<x-layouts::app :title="__('Facturen')">
    <section class="w-full space-y-6">
        <x-page-header :title="__('Facturen')" :description="__('Beheer verkoopfacturen en betaalstatus.')" />

        <x-coming-soon :heading="__('Overzicht')">
            {{ __('Hier komen alle facturen met factuurnummer, klant, bedrag, vervaldatum en status, zodat je ziet welke openstaan of vervallen zijn.') }}
        </x-coming-soon>
    </section>
</x-layouts::app>
