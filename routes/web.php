<?php

use App\Livewire\FaultReports\Index as FaultReportIndex;
use App\Models\FaultReport;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::livewire('storingen', FaultReportIndex::class)
        ->middleware('can:viewAny,'.FaultReport::class)
        ->name('fault-reports.index');

    // Simpele pagina's die later verder uitgewerkt worden.
    Route::view('werkbonnen', 'pages.werkbonnen')->name('work-orders.index');
    Route::view('planning', 'pages.planning')->name('planning.index');
    Route::view('taken', 'pages.taken')->name('tasks.index');
    Route::view('berichten', 'pages.berichten')->name('messages.index');
    Route::view('facturen', 'pages.facturen')->name('invoices.index');
    Route::view('betalingen', 'pages.betalingen')->name('payments.index');
    Route::view('rapportages', 'pages.rapportages')->name('reports.index');
    Route::view('meldingen', 'pages.meldingen')->name('notifications.index');
});

require __DIR__.'/settings.php';
