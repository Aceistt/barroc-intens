<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_valid_users_with_a_shared_nonprivileged_role(): void
    {
        $users = User::factory()->count(2)->create();

        foreach ($users as $user) {
            $user->refresh();

            $this->assertMatchesRegularExpression('/^06[0-9]{8}$/', $user->telephone);
            $this->assertTrue($user->hasRole(Role::DEFAULT_NAME));
            $this->assertFalse($user->hasRole('Admin'));
            $this->assertTrue($user->role->users->contains($user));
        }

        $this->assertDatabaseCount('roles', 1);
    }

    public function test_users_require_a_telephone(): void
    {
        $this->expectException(QueryException::class);

        User::factory()->create(['telephone' => null]);
    }

    public function test_users_require_a_role(): void
    {
        $this->expectException(QueryException::class);

        User::factory()->create(['role_id' => null]);
    }

    public function test_users_cannot_reference_a_missing_role(): void
    {
        $this->expectException(QueryException::class);

        User::factory()->create(['role_id' => 999]);
    }

    public function test_assigned_roles_cannot_be_deleted(): void
    {
        $user = User::factory()->create();

        $this->expectException(QueryException::class);

        $user->role->delete();
    }

    public function test_telephone_migration_preserves_existing_users_and_roles(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('telephone')->change();
        });

        $user = User::factory()->create(['telephone' => '123456789']);
        $roleId = $user->role_id;

        $migration = require database_path('migrations/2026_11_24_000000_store_user_telephone_as_string.php');
        $migration->up();

        $this->assertSame('123456789', $user->refresh()->telephone);
        $this->assertSame($roleId, $user->role_id);
        $this->assertTrue($user->hasRole(Role::DEFAULT_NAME));
    }

    public function test_seeders_can_be_run_repeatedly_without_duplicate_roles_or_users(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('roles', 7);
        $this->assertDatabaseCount('users', 6);
        $this->assertTrue(User::firstOrFail()->hasRole('Admin'));
        $this->assertDatabaseCount('fault_reports', 18);
    }

    public function test_seeded_demo_accounts_are_email_verified(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(0, User::whereNull('email_verified_at')->count());
    }

    public function test_admin_seeder_does_not_promote_or_overwrite_an_existing_account(): void
    {
        $user = User::factory()->create(['email' => 'admin@example.com']);
        $originalAttributes = $user->refresh()->getAttributes();

        $this->seed(DatabaseSeeder::class);

        $this->assertSame($originalAttributes, $user->refresh()->getAttributes());
        $this->assertTrue($user->hasRole(Role::DEFAULT_NAME));
    }

    public function test_demo_admin_is_not_seeded_in_production(): void
    {
        $this->app->instance('env', 'production');

        app(AdminSeeder::class)->run();

        $this->assertDatabaseCount('users', 0);
    }
}
