<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'official_id',
        'title',
        'issuer',
        'year',
        'description'
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    public function official()
    {
        return $this->belongsTo(Official::class);
    }

    public function getTable()
    {
        return 'awards';
    }
}