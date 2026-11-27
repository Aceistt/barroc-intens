<?php

namespace Tests\Feature;

use App\Livewire\FaultReports\Index;
use App\Models\Customer;
use App\Models\FaultReport;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FaultReportIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    private function userWithRole(string $roleName): User
    {
        return User::factory()->for(Role::firstOrCreate(['name' => $roleName]))->create();
    }

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get(route('fault-reports.index'))->assertRedirect(route('login'));
    }

    #[DataProvider('allowedRoles')]
    public function test_maintenance_and_planner_can_see_fault_reports_from_the_database(string $roleName): void
    {
        $report = FaultReport::factory()
            ->for(Customer::factory()->state(['company_name' => 'Café Noord']))
            ->create([
                'machine' => 'Barroc Espresso Pro',
                'description' => 'Lekkage espressomachine',
                'priority' => 'hoog',
                'status' => 'open',
            ]);

        $this->actingAs($this->userWithRole($roleName))
            ->get(route('fault-reports.index'))
            ->assertOk()
            ->assertSeeText($report->number())
            ->assertSeeText('Café Noord')
            ->assertSeeText('Barroc Espresso Pro')
            ->assertSeeText('Lekkage espressomachine')
            ->assertSeeText('Hoog')
            ->assertSeeText('Open');
    }

    /** @return array<string, array{string}> */
    public static function allowedRoles(): array
    {
        return [
            'maintenance' => ['Maintenance'],
            'planner' => ['Planner'],
        ];
    }

    #[DataProvider('forbiddenRoles')]
    public function test_other_roles_cannot_see_the_overview(string $roleName): void
    {
        $this->actingAs($this->userWithRole($roleName))
            ->get(route('fault-reports.index'))
            ->assertForbidden();
    }

    /** @return array<string, array{string}> */
    public static function forbiddenRoles(): array
    {
        return [
            'admin' => ['Admin'],
            'sales' => ['Sales'],
            'finance' => ['Finance'],
            'inkoop' => ['Inkoop'],
            'default user' => [Role::DEFAULT_NAME],
        ];
    }

    public function test_overview_can_be_filtered_and_searched(): void
    {
        $customer = Customer::factory()->create(['company_name' => 'Bakkerij Zuid']);
        FaultReport::factory()->for($customer)->create(['description' => 'Urgent probleem', 'priority' => 'urgent', 'status' => 'open']);
        FaultReport::factory()->create(['description' => 'Opgelost probleem', 'priority' => 'laag', 'status' => 'opgelost']);

        $this->actingAs($this->userWithRole('Maintenance'));

        Livewire::test(Index::class)
            ->set('priority', 'urgent')
            ->assertSee('Urgent probleem')
            ->assertDontSee('Opgelost probleem')
            ->set('priority', '')
            ->set('status', 'opgelost')
            ->assertSee('Opgelost probleem')
            ->assertDontSee('Urgent probleem')
            ->set('status', '')
            ->set('search', 'Bakkerij')
            ->assertSee('Urgent probleem')
            ->assertDontSee('Opgelost probleem');
    }

    public function test_stat_cards_count_open_and_in_progress_reports(): void
    {
        FaultReport::factory()->count(2)->create(['status' => 'open', 'priority' => 'normaal']);
        FaultReport::factory()->create(['status' => 'in_behandeling', 'priority' => 'urgent']);

        $this->actingAs($this->userWithRole('Maintenance'));

        Livewire::test(Index::class)
            ->assertViewHas('stats', fn (array $stats) => $stats[0]['value'] === 2
                && $stats[1]['value'] === 1
                && $stats[2]['value'] === 1);
    }

    public function test_sidebar_links_maintenance_to_the_overview(): void
    {
        $this->actingAs($this->userWithRole('Maintenance'))
            ->get(route('dashboard'))
            ->assertSee(route('fault-reports.index'));
    }
}
