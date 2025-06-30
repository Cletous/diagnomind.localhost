<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalReview extends Model
{
    protected $table = 'hospital_reviews';

    protected $fillable = ['hospital_id', 'patient_id', 'review', 'rating'];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

}
