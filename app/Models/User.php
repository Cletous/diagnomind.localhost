<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'national_id_number',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'name',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function assignRole($roleName)
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        if (!$this->roles()->where('role_id', $role->id)->exists()) {
            $this->roles()->syncWithoutDetaching($role->id);
        }
    }

    public function removeRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $this->roles()->detach($role->id);
        }
    }

    public function getRoleNames()
    {
        return $this->roles()->pluck('name')->toArray();
    }

    public function diagnosesGiven()
    {
        return $this->hasMany(DiagnosisRequest::class, 'doctor_id');
    }

    public function diagnosesReceived()
    {
        return $this->hasMany(DiagnosisRequest::class, 'patient_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class, 'hospital_doctor', 'doctor_id', 'hospital_id')->withTimestamps();
    }

    public function hospitalsAdministered()
    {
        return $this->hasMany(Hospital::class, 'admin_id');
    }

    public function diagnosisRequests()
    {
        return $this->hasMany(DiagnosisRequest::class, 'patient_id');
    }

    public function doctorReviews()
    {
        return $this->hasMany(DoctorReview::class, 'doctor_id');
    }

}
