<?php

namespace App\Policies;

use App\Models\User;

class FaultReportPolicy
{
    /** Rollen die het storingenoverzicht mogen bekijken (US04). */
    private const VIEW_ROLES = ['Maintenance', 'Planner'];

    public function viewAny(User $user): bool
    {
        return in_array($user->role?->name, self::VIEW_ROLES, true);
    }
}
