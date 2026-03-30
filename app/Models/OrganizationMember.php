<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_position_id',
        'user_id',
    ];

    public function position()
    {
        return $this->belongsTo(OrganizationPosition::class, 'organization_position_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}