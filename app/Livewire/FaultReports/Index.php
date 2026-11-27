<?php

namespace App\Livewire\FaultReports;

use App\Models\FaultReport;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Storingen')]
class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $priority = '';

    #[Url(except: '')]
    public string $status = '';

    public function mount(): void
    {
        $this->authorize('viewAny', FaultReport::class);
    }

    /** Bij een nieuw filter terug naar pagina 1. */
    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'priority', 'status'], true)) {
            $this->resetPage();
        }
    }

    public function render(): View
    {
        $faultReports = FaultReport::query()
            ->with('customer')
            ->when($this->search !== '', function (Builder $query) {
                $search = trim($this->search);
                $number = (int) preg_replace('/\D/', '', $search);

                $query->where(function (Builder $query) use ($search, $number) {
                    $query->where('machine', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('customer', fn (Builder $customer) => $customer->where('company_name', 'like', "%{$search}%"));

                    if ($number > 0) {
                        $query->orWhere('id', $number);
                    }
                });
            })
            ->when(array_key_exists($this->priority, FaultReport::PRIORITIES), fn (Builder $query) => $query->where('priority', $this->priority))
            ->when(array_key_exists($this->status, FaultReport::STATUSES), fn (Builder $query) => $query->where('status', $this->status))
            ->latest()
            ->latest('id')
            ->paginate(10);

        return view('livewire.fault-reports.index', [
            'faultReports' => $faultReports,
            'stats' => [
                ['label' => 'Open', 'value' => FaultReport::where('status', 'open')->count(), 'caption' => 'Meldingen'],
                ['label' => 'Urgent', 'value' => FaultReport::where('priority', 'urgent')->where('status', '!=', 'opgelost')->count(), 'caption' => 'Direct actie'],
                ['label' => 'In behandeling', 'value' => FaultReport::where('status', 'in_behandeling')->count(), 'caption' => 'Monteur bezig'],
                ['label' => 'Opgelost', 'value' => FaultReport::where('status', 'opgelost')->where('resolved_at', '>=', now()->startOfMonth())->count(), 'caption' => 'Deze maand'],
            ],
        ]);
    }
}
