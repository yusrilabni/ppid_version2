<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = ['official_id', 'name'];

    public function official()
    {
        return $this->belongsTo(Official::class);
    }
}
