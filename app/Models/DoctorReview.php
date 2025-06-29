<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorReview extends Model
{

    protected $table = 'doctor_reviews';

    protected $fillable = ['doctor_id', 'patient_id', 'review', 'rating'];
}
