<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaqAnswer extends Model
{
    protected $fillable = [
        'organization_id',
        'indicator_id',
        'jawaban',
        'alasan',
        'visibility',
        'judul',
        'link',
        'created_by',
    ];

    public function getAlasanAttribute($value)
    {
        if ($value !== null && $value !== '') {
            return $value;
        }
        if ($this->jawaban === 'tidak' && !empty($this->judul)) {
            return str_starts_with($this->judul, 'Tidak Ada: ') ? substr($this->judul, 11) : $this->judul;
        }
        return null;
    }

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
