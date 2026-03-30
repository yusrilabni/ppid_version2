<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandarLayanan extends Model
{
    protected $guarded = ['id'];

    public function subStandarLayanans()
    {
        return $this->hasMany(SubStandarLayanan::class)->orderBy('order');
    }
}
