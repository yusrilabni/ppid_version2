<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaqAnswer extends Model
{
    protected $fillable = [
        'organization_id',
        'indicator_id',
        'jawaban',
        'visibility',
        'judul',
        'link',
        'created_by',
    ];

    protected $casts = [
        'jawaban' => 'string',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function indicator()
    {
        return $this->belongsTo(SaqIndicator::class, 'indicator_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function links()
    {
        return $this->hasMany(SaqAnswerLink::class, 'saq_answer_id')->orderBy('order');
    }
}
