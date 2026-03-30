<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $fillable = [
        'survey_id',
        'section_id',
        'question_text',
        'question_type',
        'is_required',
        'order',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function section()
    {
        return $this->belongsTo(SurveySection::class);
    }

    public function options()
    {
        return $this->hasMany(SurveyOption::class, 'question_id');
    }

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class, 'question_id');
    }
}
