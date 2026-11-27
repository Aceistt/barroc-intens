<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'contact_name' => fake()->name(),
            'email' => fake()->unique()->companyEmail(),
            'telephone' => fake()->numerify('06########'),
            'address' => fake()->streetAddress(),
            'postal_code' => fake()->numerify('####').' '.strtoupper(fake()->lexify('??')),
            'city' => fake()->city(),
            'bkr_check' => fake()->boolean(),
            'notes' => null,
        ];
    }
}
