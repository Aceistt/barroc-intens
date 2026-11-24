<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white text-slate-900">
        @php
            $userRole = strtolower(trim(auth()->user()?->role?->name ?? ''));
            $userRole = match ($userRole) {
                'administrator' => 'admin',
                'onderhoud' => 'maintenance',
                default => $userRole,
            };
            $roleNavigation = [
                'admin' => [
                    'label' => 'Admin',
                    'tabs' => ['Dashboard', 'Klanten', 'Sales', 'Inkoop', 'Planning', 'Onderhoud', 'Finance', 'Gebruikers', 'Instellingen'],
                ],
                'sales' => ['label' => 'Sales', 'tabs' => ['Dashboard', 'Klanten', 'Leads', 'Offertes', 'Orders', 'Taken', 'Berichten']],
                'finance' => ['label' => 'Finance', 'tabs' => ['Dashboard', 'Facturen', 'Betalingen', 'Rapportages', 'Taken', 'Meldingen']],
                'inkoop' => ['label' => 'Inkoop', 'tabs' => ['Dashboard', 'Voorraad', 'Leveranciers', 'Inkooporders', 'Taken', 'Berichten']],
                'maintenance' => ['label' => 'Maintenance', 'tabs' => ['Dashboard', 'Storingen', 'Werkbonnen', 'Planning', 'Taken', 'Berichten']],
                'planner' => ['label' => 'Planner', 'tabs' => ['Dashboard', 'Planning', 'Afspraken', 'Storingen']],
            ];
            $navigation = $roleNavigation[$userRole] ?? null;
        @endphp

        <aside class="fixed inset-y-0 left-0 z-40 flex w-[202px] flex-col border-r border-slate-200 bg-white">
            <div class="flex h-[119px] flex-col justify-center px-3">
                <a href="{{ route('dashboard') }}" class="block" wire:navigate>
                    <span class="block text-[16px] font-black leading-none tracking-tight text-slate-950">BARROC INTENS</span>
                    <span class="mt-3 block text-[10px] font-bold uppercase leading-none text-slate-950">Vlamend lekkere koffie</span>
                </a>
            </div>

            <nav class="overflow-y-auto px-[14px]" aria-label="Hoofdnavigatie">
                @foreach ($navigation['tabs'] ?? [] as $tab)
                    <a href="{{ $tab === 'Dashboard' ? route('dashboard') : '#' }}"
                       class="flex h-10 items-center px-2.5 text-[13px] {{ $tab === 'Dashboard' && request()->routeIs('dashboard') ? 'rounded-md bg-[#e7edf8] text-[#6d7d96]' : 'text-slate-800 hover:bg-slate-50' }}"
                       @if ($tab === 'Dashboard') wire:navigate @endif>
                        {{ $tab }}
                    </a>
                @endforeach
            </nav>

            @if ($navigation)
                <div class="mt-auto border-t border-slate-100 px-[22px] pb-[42px] pt-[31px]">
                    <div class="flex h-[34px] items-center justify-center rounded-full bg-[#0f9bf0] text-[10px] font-extrabold uppercase text-white">
                        {{ $navigation['label'] }}
                    </div>
                </div>
            @endif
        </aside>

        <main class="min-h-screen pl-[202px]">
            {{ $slot }}
        </main>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
