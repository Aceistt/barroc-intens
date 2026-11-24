<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Features;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->skipUnlessFortifyHas(Features::registration());
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertOk()->assertSee('name="telephone"', false);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'telephone' => '0612345678',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();

        $user = User::where('email', 'test@example.com')->firstOrFail();

        $this->assertSame('0612345678', $user->telephone);
        $this->assertTrue($user->hasRole(Role::DEFAULT_NAME));
        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertNull($user->email_verified_at);

        $this->get(route('dashboard'))->assertRedirect(route('verification.notice'));
    }

    public function test_public_registration_cannot_assign_a_privileged_role(): void
    {
        $admin = Role::create(['name' => 'Admin']);

        $this->post(route('register.store'), [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'telephone' => '+31 (0)6 1234-5678',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => $admin->id,
            'role' => 'Admin',
            'email_verified_at' => now()->toDateTimeString(),
        ])->assertSessionHasNoErrors()->assertRedirect('/dashboard');

        $user = User::where('email', 'test@example.com')->firstOrFail();

        $this->assertTrue($user->hasRole(Role::DEFAULT_NAME));
        $this->assertFalse($user->hasRole('Admin'));
        $this->assertSame('+31 (0)6 1234-5678', $user->telephone);
        $this->assertNull($user->email_verified_at);
    }

    #[DataProvider('invalidTelephones')]
    public function test_registration_rejects_invalid_telephone_numbers(mixed $telephone): void
    {
        $this->post(route('register.store'), [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'telephone' => $telephone,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors('telephone');

        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    /** @return array<string, array{mixed}> */
    public static function invalidTelephones(): array
    {
        return [
            'missing' => [null],
            'empty' => [''],
            'letters' => ['not-a-phone'],
            'too short' => ['123'],
            'too long' => [str_repeat('1', 26)],
            'array' => [['0612345678']],
        ];
    }
}
