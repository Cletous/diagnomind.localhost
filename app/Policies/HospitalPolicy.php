<?php

namespace App\Policies;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HospitalPolicy
{
    /**
     * Only the admin of the hospital can invite doctors.
     */
    public function invite(User $user, Hospital $hospital): Response
    {
        return $user->id === $hospital->admin_id
            ? Response::allow()
            : Response::deny('Only the hospital administrator can invite doctors to this hospital.');
    }

    /**
     * Admin can update the hospital.
     */
    public function update(User $user, Hospital $hospital): Response
    {
        return $user->id === $hospital->admin_id
            ? Response::allow()
            : Response::deny('You are not authorized to edit this hospital.');
    }
}
