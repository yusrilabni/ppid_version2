<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbjAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'pbj_question_id',
        'user_id',
        'answer_text',
        'document_url',
        'document_file_path',
        'year',
        'informasi_id',
    ];

    public function question()
    {
        return $this->belongsTo(PbjQuestion::class, 'pbj_question_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function informasi()
    {
        return $this->belongsTo(Informasi::class);
    }
}
