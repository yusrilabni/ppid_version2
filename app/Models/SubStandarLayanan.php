<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubStandarLayanan extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $slug = Str::slug($model->title);
            $originalSlug = $slug;
            $count = 1;
            
            while (static::where('slug', $slug)->where('id', '!=', $model->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $model->slug = $slug;
        });
    }

    public function standarLayanan()
    {
        return $this->belongsTo(StandarLayanan::class);
    }

    public function informasi()
    {
        return $this->hasOne(Informasi::class);
    }
}
