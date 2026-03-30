<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'official_id',
        'title',
        'organization_name',
        'start_year',
        'end_year',
        'description'
    ];

    protected $casts = [
        'start_year' => 'integer',
        'end_year' => 'integer',
    ];

    public function official()
    {
        return $this->belongsTo(Official::class);
    }

    public function getTable()
    {
        return 'career_histories';
    }
}