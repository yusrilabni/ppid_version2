<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'order',
        'active',
        'show_title',
        'show_description',
        'jenis_dokumen',
        'category',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('home_sliders');
        });

        static::deleted(function () {
            Cache::forget('home_sliders');
        });
    }
}
