<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanInformasi extends Model
{
    use HasFactory;

    protected $table = 'permohonan_informasi';

    protected $fillable = [
        'user_id', // Added user_id to fillable
        'nama_pemohon',
        'alamat_pemohon',
        'pekerjaan',
        'nomor_telepon_pemohon',
        'email_pemohon',
        'detail_informasi',
        'tujuan_penggunaan_informasi',
        'cara_memperoleh_informasi',
        'cara_mendapatkan_salinan',
        'tempat_mendapatkan_salinan',
        'privacy_status',
        'rating',
        'unique_code',
    ];

    /**
     * Get the user that owns the PermohonanInformasi.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the responses for the permohonan informasi.
     */
    public function responses()
    {
        return $this->hasMany(PermohonanResponse::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'unique_code';
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('all_home');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('all_home');
        });
    }
}
