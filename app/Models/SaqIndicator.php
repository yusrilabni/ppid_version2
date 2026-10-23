<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaqIndicator extends Model
{
    protected $fillable = [
        'parent_id',
        'tab',
        'kode',
        'pertanyaan',
        'section',
        'petunjuk',
        'dokumen_upload',
        'unit_terkait',
        'is_category',
        'order',
        'scope',
    ];

    protected $casts = [
        'is_category' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(SaqIndicator::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(SaqIndicator::class, 'parent_id')->orderBy('order');
    }

    public function organizations()
    {
        return $this->belongsToMany(
            Organization::class,
            'indicator_opd',
            'indicator_id',
            'organization_id'
        );
    }

    public function answers()
    {
        return $this->hasMany(SaqAnswer::class, 'indicator_id');
    }
}
