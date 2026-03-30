<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationalHistory extends Model
{
    use HasFactory;

    protected $fillable = ['official_id', 'organization_name', 'position', 'start_year', 'end_year'];

    public function official()
    {
        return $this->belongsTo(Official::class);
    }
}
