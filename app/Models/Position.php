<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_single', // Whether only one person can hold this position (like Bupati, Sekda)
    ];

    protected $casts = [
        'is_single' => 'boolean',
    ];

    public function officials()
    {
        return $this->hasMany(Official::class);
    }
}