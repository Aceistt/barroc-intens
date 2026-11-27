<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestAccsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            return;
        }

        $testAccounts = [
            'Sales' => [
                'name' => 'Sales',
                'email' => 'sales@example.com',
                'telephone' => '1234567891',
            ],
            'Finance' => [
                'name' => 'Finance',
                'email' => 'finance@example.com',
                'telephone' => '1234567892',
            ],
            'Maintenance' => [
                'name' => 'Maintenance',
                'email' => 'maintenance@example.com',
                'telephone' => '1234567893',
            ],
            'Inkoop' => [
                'name' => 'Inkoop',
                'email' => 'inkoop@example.com',
                'telephone' => '1234567894',
            ],
            'Planner' => [
                'name' => 'Planner',
                'email' => 'planner@example.com',
                'telephone' => '1234567895',
            ],
        ];

        foreach ($testAccounts as $roleName => $account) {
            $role = Role::where('name', $roleName)->first();

            if ($role === null) {
                throw new \RuntimeException(
                    "{$roleName} role not found. Run RoleSeeder first."
                );
            }

            $user = User::firstOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'telephone' => $account['telephone'],
                    'password' => Hash::make('password'),
                    'role_id' => $role->id,
                ]
            );

            // Testaccounts direct als geverifieerd markeren, anders blokkeert de 'verified'-middleware ze.
            if ($user->wasRecentlyCreated) {
                $user->forceFill(['email_verified_at' => now()])->save();
            }
        }
    }
}
