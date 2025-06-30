<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function doctors()
    {
        return $this->belongsToMany(User::class, 'hospital_doctor', 'hospital_id', 'doctor_id')->withTimestamps();
    }

    public function diagnoses()
    {
        return $this->hasMany(DiagnosisRequest::class);
    }

    public function reviews()
    {
        return $this->hasMany(HospitalReview::class);
    }
}
