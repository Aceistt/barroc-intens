<?php

namespace App\Models;

use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    /** @use HasFactory<CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_name',
        'email',
        'telephone',
        'address',
        'postal_code',
        'city',
        'bkr_check',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'bkr_check' => 'boolean',
        ];
    }

    /**
     * @return HasMany<FaultReport, $this>
     */
    public function faultReports(): HasMany
    {
        return $this->hasMany(FaultReport::class);
    }
}
