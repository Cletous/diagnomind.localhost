<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewDiagnosisHistory(User $requester, User $target): Response
    {
        return $requester->id === $target->id
            || $requester->hasRole('doctor')
            || $requester->hasRole('admin') ? Response::allow()
            : Response::deny('Unauthorized to view this patient\'s history.');
        ;
    }

}
