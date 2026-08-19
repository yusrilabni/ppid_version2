<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'video',
        'type',
        'is_pinned',
        'category',
        'jenis_dokumen',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('all_home');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('all_home');
        });
    }

}
