<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaqAnswerLink extends Model
{
    protected $fillable = [
        'saq_answer_id',
        'judul',
        'link',
        'deskripsi',
        'order',
    ];

    public function answer()
    {
        return $this->belongsTo(SaqAnswer::class, 'saq_answer_id');
    }
}
