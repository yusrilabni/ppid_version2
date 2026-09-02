<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwibbonSession extends Model
{
    protected $fillable = ['twibbon_id', 'result_image_path'];

    public function twibbon()
    {
        return $this->belongsTo(Twibbon::class);
    }

    public function photos()
    {
        return $this->hasMany(TwibbonSessionPhoto::class);
    }
}
