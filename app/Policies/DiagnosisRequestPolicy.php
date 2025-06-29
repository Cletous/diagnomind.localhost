<?php

namespace App\Policies;

use App\Models\DiagnosisRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DiagnosisRequestPolicy
{
    public function rateDiagnosis(User $user, DiagnosisRequest $diagnosis): Response
    {
        return $user->id === $diagnosis->patient_id ? Response::allow()
            : Response::deny('Only the owner of the diagnosis can rate the diagnosis.');
    }
}
