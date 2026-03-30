<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'jenis_kelamin',
        'slug',
        'position_id',
        'organization_id',
        'birth_place',
        'birth_date',
        'religion',
        'nip',
        'biography',
        'photo',
        'start_term',
        'end_term',
        'status', // active, inactive, draft
        'created_by',
        'updated_by',
        'marital_status',
        'occupation',
        'email',
        'home_address',
        'spouse_name',
        'status_jabatan',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'start_term' => 'date',
        'end_term' => 'date',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function members()
    {
        return $this->hasMany(OrganizationMember::class, 'organization_position_id');
    }

    public function careerHistories()
    {
        return $this->hasMany(\App\Models\CareerHistory::class);
    }

    public function educations()
    {
        return $this->hasMany(\App\Models\Education::class);
    }

    public function awards()
    {
        return $this->hasMany(\App\Models\Award::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function trainingHistories()
    {
        return $this->hasMany(TrainingHistory::class);
    }

    public function organizationalHistories()
    {
        return $this->hasMany(OrganizationalHistory::class);
    }

    public function lhkpns()
    {
        return $this->hasMany(Lhkpn::class);
    }
}