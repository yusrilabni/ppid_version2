<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingHistory extends Model
{
    use HasFactory;

    protected $fillable = ['official_id', 'name', 'year', 'organizer'];

    public function official()
    {
        return $this->belongsTo(Official::class);
    }
}
