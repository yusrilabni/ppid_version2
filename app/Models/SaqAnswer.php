<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaqAnswer extends Model
{
    protected $fillable = [
        'organization_id',
        'indicator_id',
        'judul',
        'link',
        'created_by',
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
}
