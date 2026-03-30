<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanResponse extends Model
{
    use HasFactory;

    protected $table = 'permohonan_responses';

    protected $fillable = [
        'permohonan_informasi_id',
        'user_id',
        'message',
        'response_type',
        'file_path',
        'link',
    ];

    /**
     * Get the user who created the response.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the permohonan that the response belongs to.
     */
    public function permohonanInformasi()
    {
        return $this->belongsTo(PermohonanInformasi::class);
    }
}
