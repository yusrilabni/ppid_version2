<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'official_id',
        'degree',
        'institution',
        'start_year',
        'end_year'
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
        return 'educations';
    }
}