<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    protected $fillable = [
        'organization_id',
        'title',
        'image_path',
        'document_path',
        'category',
        'jenis_dokumen',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function informasi()
    {
        return $this->hasOne(Informasi::class, 'content', 'content_identifier');
    }

    public function getContentIdentifierAttribute()
    {
        return 'struktur_organisasi_' . $this->organization_id;
    }
}

