<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class KeberatanInformasi extends Model
{
    use HasFactory;

    protected $table = 'keberatan_informasi';

    protected $fillable = [
        'user_id',
        'permohonan_informasi_id',
        'nomor_pendaftaran_pemohon',
        'nama_pemohon',
        'alamat_pemohon',
        'pekerjaan',
        'nomor_telepon_pemohon',
        'email_pemohon',
        'nama_kuasa',
        'alamat_kuasa',
        'nomor_telepon_kuasa',
        'surat_kuasa_path',
        'alasan_keberatan',
        'kasus_posisi',
        'privacy_status',
        'status_keberatan',
        'tanggal_tanggapan',
        'unique_code',
    ];

    /**
     * Get the user that submitted the objection.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent information request if available.
     */
    public function permohonan()
    {
        return $this->belongsTo(PermohonanInformasi::class, 'permohonan_informasi_id');
    }

    /**
     * Get route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'unique_code';
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('all_home');
        });

        static::deleted(function () {
            Cache::forget('all_home');
        });
    }
}
