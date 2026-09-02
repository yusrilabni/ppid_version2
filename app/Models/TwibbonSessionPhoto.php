<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwibbonSessionPhoto extends Model
{
    protected $fillable = ['twibbon_session_id', 'raw_image_path'];

    public function session()
    {
        return $this->belongsTo(TwibbonSession::class, 'twibbon_session_id');
    }
}
