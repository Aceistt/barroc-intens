<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Testroutes die alleen tijdens deze tests bestaan.
        Route::middleware(['web', 'auth', 'role:Sales'])
            ->get('/_test/sales', fn () => 'sales ok');

        Route::middleware(['web', 'auth', 'role:Sales,Maintenance'])
            ->get('/_test/sales-of-maintenance', fn () => 'gedeeld ok');
    }

    private function userWithRole(string $roleName): User
    {
        $role = Role::firstOrCreate(['name' => $roleName]);

        return User::factory()->for($role)->create();
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/_test/sales')->assertRedirect(route('login'));
    }

    public function test_user_with_correct_role_gets_access(): void
    {
        $this->actingAs($this->userWithRole('Sales'))
            ->get('/_test/sales')
            ->assertOk()
            ->assertSee('sales ok');
    }

    public function test_user_with_wrong_role_gets_forbidden(): void
    {
        $this->actingAs($this->userWithRole('Finance'))
            ->get('/_test/sales')
            ->assertForbidden();
    }

    public function test_admin_has_no_automatic_access(): void
    {
        $this->actingAs($this->userWithRole('Admin'))
            ->get('/_test/sales')
            ->assertForbidden();
    }

    public function test_any_of_multiple_roles_gets_access(): void
    {
        $this->actingAs($this->userWithRole('Maintenance'))
            ->get('/_test/sales-of-maintenance')
            ->assertOk();

        $this->actingAs($this->userWithRole('Sales'))
            ->get('/_test/sales-of-maintenance')
            ->assertOk();
    }

    public function test_other_role_is_forbidden_on_shared_route(): void
    {
        $this->actingAs($this->userWithRole('Inkoop'))
            ->get('/_test/sales-of-maintenance')
            ->assertForbidden();
    }
}
