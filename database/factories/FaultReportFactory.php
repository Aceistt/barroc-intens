<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\FaultReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FaultReport>
 */
class FaultReportFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(array_keys(FaultReport::STATUSES));

        return [
            'customer_id' => Customer::factory(),
            'user_id' => User::factory(),
            'machine' => fake()->randomElement(['Barroc Espresso Pro', 'Barroc Bean Master', 'Barroc Latte Deluxe', 'Barroc Office Compact']),
            'description' => fake()->randomElement([
                'Machine lekt water aan de onderkant.',
                'Machine gaat niet meer aan.',
                'Koffie komt er lauw uit.',
                'Melkopschuimer werkt niet.',
                'Foutmelding E04 op het display.',
                'Bonenmaler maakt een hard geluid.',
            ]),
            'priority' => fake()->randomElement(array_keys(FaultReport::PRIORITIES)),
            'status' => $status,
            'resolved_at' => $status === 'opgelost' ? fake()->dateTimeBetween('-1 month') : null,
        ];
    }
}
