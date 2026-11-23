<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $user = User::factory()->create();
        $user->setAttribute('role', 'admin');

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();

        foreach (['Dashboard', 'Klanten', 'Sales', 'Inkoop', 'Planning', 'Onderhoud', 'Finance', 'Gebruikers', 'Instellingen'] as $tab) {
            $response->assertSee($tab);
        }

        foreach (['Facturen', 'Betalingen', 'Rapportages', 'Taken', 'Meldingen', 'Leads', 'Offertes', 'Orders', 'Berichten', 'Voorraad', 'Leveranciers', 'Inkooporders', 'Storingen', 'Werkbonnen', 'Afspraken'] as $tab) {
            $response->assertDontSee($tab);
        }
    }

    public function test_department_sidebar_only_shows_its_role_tabs(): void
    {
        $roleTabs = [
            'finance' => ['Dashboard', 'Facturen', 'Betalingen', 'Rapportages', 'Taken', 'Meldingen'],
            'sales' => ['Dashboard', 'Klanten', 'Leads', 'Offertes', 'Orders', 'Taken', 'Berichten'],
            'inkoop' => ['Dashboard', 'Voorraad', 'Leveranciers', 'Inkooporders', 'Taken', 'Berichten'],
            'maintenance' => ['Dashboard', 'Storingen', 'Werkbonnen', 'Planning', 'Taken', 'Berichten'],
            'planner' => ['Dashboard', 'Planning', 'Afspraken', 'Storingen'],
        ];

        foreach ($roleTabs as $role => $tabs) {
            $user = User::factory()->create();
            $user->setAttribute('role', $role);
            $response = $this->actingAs($user)->get(route('dashboard'));

            $response->assertOk();

            foreach ($tabs as $tab) {
                $response->assertSee($tab);
            }

            $response->assertDontSee('Gebruikers');
        }
    }
}
