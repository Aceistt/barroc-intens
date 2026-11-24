<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_visit_the_dashboard(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertOk()
            ->assertDontSee('Klanten')
            ->assertDontSee('Finance');
    }

    public function test_admin_sidebar_matches_the_admin_dashboard_wireframe(): void
    {
        $role = Role::create(['name' => 'Admin']);
        $user = User::factory()->for($role)->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();

        foreach (['Dashboard', 'Klanten', 'Sales', 'Inkoop', 'Planning', 'Onderhoud', 'Finance', 'Gebruikers', 'Instellingen'] as $tab) {
            $response->assertSee($tab);
        }

        foreach (['Facturen', 'Betalingen', 'Rapportages', 'Taken', 'Meldingen', 'Leads', 'Offertes', 'Orders', 'Berichten', 'Voorraad', 'Leveranciers', 'Inkooporders', 'Storingen', 'Werkbonnen', 'Afspraken'] as $tab) {
            $response->assertDontSee($tab);
        }
    }

    #[DataProvider('departmentNavigation')]
    public function test_department_sidebar_only_shows_its_role_tabs(string $roleName, array $tabs): void
    {
        $role = Role::create(['name' => $roleName]);
        $user = User::factory()->for($role)->create();
        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();

        foreach ($tabs as $tab) {
            $response->assertSeeText($tab);
        }

        $departmentTabs = ['Klanten', 'Facturen', 'Betalingen', 'Rapportages', 'Taken', 'Meldingen', 'Leads', 'Offertes', 'Orders', 'Berichten', 'Voorraad', 'Leveranciers', 'Inkooporders', 'Storingen', 'Werkbonnen', 'Planning', 'Afspraken', 'Gebruikers', 'Instellingen'];

        foreach (array_diff($departmentTabs, $tabs) as $tab) {
            $response->assertDontSeeText($tab);
        }
    }

    /** @return array<string, array{string, list<string>}> */
    public static function departmentNavigation(): array
    {
        return [
            'finance' => ['Finance', ['Dashboard', 'Facturen', 'Betalingen', 'Rapportages', 'Taken', 'Meldingen']],
            'sales' => ['Sales', ['Dashboard', 'Klanten', 'Leads', 'Offertes', 'Orders', 'Taken', 'Berichten']],
            'inkoop' => ['Inkoop', ['Dashboard', 'Voorraad', 'Leveranciers', 'Inkooporders', 'Taken', 'Berichten']],
            'maintenance' => ['Maintenance', ['Dashboard', 'Storingen', 'Werkbonnen', 'Planning', 'Taken', 'Berichten']],
            'planner' => ['Planner', ['Dashboard', 'Planning', 'Afspraken', 'Storingen']],
        ];
    }
}
