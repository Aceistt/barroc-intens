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
});

require __DIR__.'/settings.php';
