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
    public function test_guests_are_redirected_to_the_login_page(string $routeName, string $heading, string $roleName): void
    {
        $this->get(route($routeName))->assertRedirect(route('login'));
    }

    #[DataProvider('pages')]
    public function test_page_renders_and_is_linked_in_the_sidebar(string $routeName, string $heading, string $roleName): void
    {
        $user = User::factory()->for(Role::firstOrCreate(['name' => $roleName]))->create();

        $this->actingAs($user)
            ->get(route($routeName))
            ->assertOk()
            ->assertSeeText($heading)
            ->assertSee(route($routeName));
    }

    /** @return array<string, array{string, string, string}> */
    public static function pages(): array
    {
        return [
            'werkbonnen' => ['work-orders.index', 'Werkbonnen', 'Maintenance'],
            'planning' => ['planning.index', 'Weekplanning', 'Maintenance'],
            'taken' => ['tasks.index', 'Taken', 'Maintenance'],
            'berichten' => ['messages.index', 'Interne berichten', 'Maintenance'],
            'facturen' => ['invoices.index', 'Facturen', 'Finance'],
            'betalingen' => ['payments.index', 'Betalingen', 'Finance'],
            'rapportages' => ['reports.index', 'Rapportages', 'Finance'],
            'meldingen' => ['notifications.index', 'Meldingen', 'Finance'],
        ];
    }
}
