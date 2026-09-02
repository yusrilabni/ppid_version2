<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Twibbon extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'status',
        'file_path',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->judul);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
