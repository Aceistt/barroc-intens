<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', ['lightOnly' => true])
    </head>
    <body class="min-h-screen bg-neutral-50 text-brand-black">
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

            // Tabs die al een eigen pagina hebben; de rest linkt voorlopig naar '#'.
            $tabRoutes = [
                'Dashboard' => 'dashboard',
                'Storingen' => 'fault-reports.index',
                'Werkbonnen' => 'work-orders.index',
                'Planning' => 'planning.index',
                'Taken' => 'tasks.index',
                'Berichten' => 'messages.index',
                'Facturen' => 'invoices.index',
                'Betalingen' => 'payments.index',
                'Rapportages' => 'reports.index',
                'Meldingen' => 'notifications.index',
            ];
        @endphp

        <aside class="fixed inset-y-0 left-0 z-40 flex w-[202px] flex-col border-r-[3px] border-brand-yellow bg-white">
            <div class="flex h-[119px] flex-col justify-center px-3">
                <a href="{{ route('dashboard') }}" class="block" wire:navigate aria-label="Barroc Intens">
                    <span class="block font-logo text-[30px] leading-[0.95] text-brand-black">Barroc<br>Intens</span>
                    <span class="mt-2 block text-[10px] font-bold uppercase leading-none text-brand-black">Vlamend lekkere koffie</span>
                </a>
            </div>

            <nav class="overflow-y-auto px-[14px]" aria-label="Hoofdnavigatie">
                @foreach ($navigation['tabs'] ?? [] as $tab)
                    @php($tabRoute = $tabRoutes[$tab] ?? null)
                    <a href="{{ $tabRoute ? route($tabRoute) : '#' }}"
                       class="flex h-10 items-center rounded-md border px-2.5 text-[13px] {{ $tabRoute && request()->routeIs($tabRoute) ? 'border-brand-yellow bg-white font-semibold text-brand-yellow-dark' : 'border-transparent text-brand-black hover:bg-brand-yellow-light' }}"
                       @if ($tabRoute) wire:navigate @endif>
                        {{ $tab }}
                    </a>
                @endforeach
            </nav>

            @if ($navigation)
                <div class="mt-auto border-t border-slate-100 px-[22px] pb-[42px] pt-[31px]">
                    <details class="group relative">
                        <summary class="flex h-[34px] cursor-pointer list-none items-center justify-center rounded-full bg-brand-yellow text-[10px] font-extrabold uppercase text-brand-black [&::-webkit-details-marker]:hidden">
                            {{ $navigation['label'] }}
                        </summary>

                        <div class="absolute bottom-full left-0 mb-2 w-[158px] rounded-lg border border-black bg-white p-3 shadow-lg">
                            <div class="min-w-0">
                                <div class="truncate text-[13px] font-bold text-slate-900">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="mt-0.5 truncate text-[11px] text-slate-500">
                                    {{ auth()->user()->email }}
                                </div>
                                <div class="mt-2 text-[10px] font-bold uppercase text-brand-yellow-dark">
                                    {{ $navigation['label'] }}
                                </div>
                            </div>

                            <form method="POST" action="{{ route('logout') }}" class="mt-3 border-t border-slate-100 pt-2">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full cursor-pointer rounded-md px-2 py-1.5 text-left text-[12px] font-semibold text-red-600 hover:bg-red-50"
                                    data-test="logout-button"
                                >
                                    Uitloggen
                                </button>
                            </form>
                        </div>
                    </details>
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
