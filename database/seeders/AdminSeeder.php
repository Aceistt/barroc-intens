<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Zoek de Admin-rol op naam
        $adminRoleId = DB::table('roles')
            ->where('name', 'Admin')
            ->value('id');

        if ($adminRoleId === null) {
            throw new \RuntimeException(
                'Admin role not found. Run RoleSeeder first.'
            );
        }

        // Maak de admin aan of werk deze bij
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'telephone' => '1234567890',
                'password' => Hash::make('password'),
                'role_id' => $adminRoleId,
            ]
        );
    }
}
