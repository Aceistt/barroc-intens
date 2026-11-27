<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\FaultReport;
use App\Models\User;
use Illuminate\Database\Seeder;

class FaultReportSeeder extends Seeder
{
    public function run(): void
    {
        // Demodata is alleen bedoeld voor lokale ontwikkeling en tests.
        if (! app()->environment(['local', 'testing'])) {
            return;
        }

        // Herhaalbaar: niet opnieuw vullen als er al storingen zijn.
        if (FaultReport::exists()) {
            return;
        }

        // Storingen worden gemeld door het Sales-testaccount uit de TestAccsSeeder.
        $sales = User::where('email', 'sales@example.com')->first();

        if ($sales === null) {
            throw new \RuntimeException(
                'Sales test account not found. Run TestAccsSeeder first.'
            );
        }

        $customers = Customer::factory()->count(6)->create();

        FaultReport::factory()
            ->count(18)
            ->recycle($customers)
            ->recycle($sales)
            ->create();
    }
}
