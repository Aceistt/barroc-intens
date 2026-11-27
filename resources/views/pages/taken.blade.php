<x-layouts::app :title="__('Taken')">
    <section class="w-full space-y-6">
        <x-page-header :title="__('Taken')" :description="__('Volg acties en verdeel verantwoordelijkheid.')" />

        <x-coming-soon :heading="__('Overzicht')">
            {{ __('Hier komen je open taken, met afdeling, eigenaar, deadline en status.') }}
        </x-coming-soon>
    </section>
</x-layouts::app>
