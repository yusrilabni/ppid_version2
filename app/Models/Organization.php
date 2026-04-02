<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'website_url',
        'remote_id', // Add remote_id to fillable
        'unit_id',   // Add unit_id to fillable
    ];

    public function positions()
    {
        return $this->hasMany(OrganizationPosition::class);
    }

    public function strukturOrganisasi()
    {
        return $this->hasOne(StrukturOrganisasi::class);
    }

    public function officials()
    {
        return $this->hasMany(Official::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}