<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PbjQuestion extends Model
{
    protected $fillable = [
        'parent_id',
        'question',
        'is_category',
        'order',
        'year',
        'requires_link_submission',
        'requires_file_submission',
    ];

    /**
     * Get the parent question.
     */
    public function parent()
    {
        return $this->belongsTo(PbjQuestion::class, 'parent_id');
    }

    /**
     * Get the child questions.
     */
    public function children()
    {
        return $this->hasMany(PbjQuestion::class, 'parent_id')->with('children')->orderBy('order');
    }
}
