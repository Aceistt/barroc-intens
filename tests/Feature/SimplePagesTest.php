<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SimplePagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    #[DataProvider('pages')]
    public function test_guests_are_redirected_to_the_login_page(string $routeName, string $heading): void
    {
        $this->get(route($routeName))->assertRedirect(route('login'));
    }

    #[DataProvider('pages')]
    public function test_page_renders_and_is_linked_in_the_maintenance_sidebar(string $routeName, string $heading): void
    {
        $user = User::factory()->for(Role::firstOrCreate(['name' => 'Maintenance']))->create();

        $this->actingAs($user)
            ->get(route($routeName))
            ->assertOk()
            ->assertSeeText($heading)
            ->assertSee(route($routeName));
    }

    /** @return array<string, array{string, string}> */
    public static function pages(): array
    {
        return [
            'werkbonnen' => ['work-orders.index', 'Werkbonnen'],
            'planning' => ['planning.index', 'Weekplanning'],
            'taken' => ['tasks.index', 'Taken'],
            'berichten' => ['messages.index', 'Interne berichten'],
        ];
    }
}
