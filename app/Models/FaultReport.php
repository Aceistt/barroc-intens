<?php

namespace App\Models;

use Database\Factories\FaultReportFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaultReport extends Model
{
    /** @use HasFactory<FaultReportFactory> */
    use HasFactory;

    /** Prioriteiten met het label dat in de app getoond wordt. */
    public const PRIORITIES = [
        'laag' => 'Laag',
        'normaal' => 'Normaal',
        'hoog' => 'Hoog',
        'urgent' => 'Urgent',
    ];

    /** Statussen met het label dat in de app getoond wordt. */
    public const STATUSES = [
        'open' => 'Open',
        'in_behandeling' => 'In behandeling',
        'opgelost' => 'Opgelost',
    ];

    protected $fillable = [
        'customer_id',
        'user_id',
        'machine',
        'description',
        'priority',
        'status',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Customer, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * De medewerker die de storing heeft gemeld.
     *
     * @return BelongsTo<User, $this>
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Storingsnummer zoals in de wireframe, bijvoorbeeld ST-041. */
    public function number(): string
    {
        return 'ST-'.str_pad((string) $this->id, 3, '0', STR_PAD_LEFT);
    }

    public function priorityLabel(): string
    {
        return self::PRIORITIES[$this->priority] ?? $this->priority;
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
