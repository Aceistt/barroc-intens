<x-layouts::app :title="__('Planning')">
    <section class="w-full space-y-6">
        <x-page-header :title="__('Weekplanning')" :description="__('Bekijk de capaciteit per monteur en plan afspraken.')" />

        <x-coming-soon :heading="__('Planning per medewerker')">
            {{ __('Hier komt de weekplanning met afspraken per monteur en de storingen die nog ingepland moeten worden.') }}
        </x-coming-soon>
    </section>
</x-layouts::app>
