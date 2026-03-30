<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $fillable = [
        'survey_id',
        'respondent_ip',
        'user_id',          // Added
        'responden_name',   // Added
        'privacy_status',   // Added
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function user() // Added user relationship
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class, 'response_id');
    }
}
