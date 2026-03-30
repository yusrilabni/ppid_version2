<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyOption extends Model
{
    protected $fillable = [
        'question_id',
        'option_text',
        'value',
        'order',
    ];

    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }
}
