<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiFeedback extends Model
{
    protected $fillable = [
        'diagnosis_request_id',
        'doctor_id',
        'comment',
    ];

    public function diagnosisRequest()
    {
        return $this->belongsTo(DiagnosisRequest::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
