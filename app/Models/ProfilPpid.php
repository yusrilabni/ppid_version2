<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPpid extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'vision',
        'mission',
        'structure_image',
        'address',
        'phone',
        'email',
        'maps_url',
        'instagram',
        'facebook',
        'twitter',
        'tiktok',
        'youtube',
        'website',
    ];

    protected $casts = [
        'status' => 'boolean',
        'mission' => 'array',
    ];
}
