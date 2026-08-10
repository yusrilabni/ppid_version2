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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('all_profil_ppid');
        });

        static::updated(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('all_profil_ppid');
        });

        static::deleted(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('all_profil_ppid');
        });
    }
}
