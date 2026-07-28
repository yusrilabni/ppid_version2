<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiPemkab extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'jenis_dokumen',
        'tahun',
        'deskripsi',
        'file_path',
        'status',
        'visibility',
        'published_at',
        'user_id',
        'unit_id',
        'ip_address',
        'views_count',
        'downloads_count'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->judul) . '-' . uniqid();
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('judul')) {
                $model->slug = \Illuminate\Support\Str::slug($model->judul) . '-' . uniqid();
            }
        });
    }

    public const KATEGORI_JENIS_DOKUMEN = [
        'Perencanaan' => ['RPJPD', 'RPJMD', 'RKPD', 'Renstra', 'Renja', 'RKA', 'KUA', 'PPAS'],
        'Keuangan' => ['APBD', 'APBD Perubahan', 'DPA', 'DPPA', 'LKPD', 'LRA', 'LO', 'Neraca', 'CaLK', 'IPKD', 'Laporan Keuangan'],
        'Peraturan dan Kebijakan' => ['Perda', 'Perbup', 'Keputusan Bupati', 'Surat Edaran', 'Instruksi'],
        'Organisasi dan Tata Laksana' => ['SOP', 'Standar Pelayanan', 'Maklumat Pelayanan', 'Peta Proses Bisnis', 'SOTK'],
        'Pelayanan Publik' => ['Formulir', 'Panduan', 'Persyaratan', 'Alur Pelayanan'],
        'Kepegawaian' => ['SK', 'SKP', 'Diklat', 'Mutasi', 'Kenaikan Pangkat'],
        'Monitoring, Evaluasi dan Pelaporan' => ['LKjIP', 'LKPJ', 'LPPD', 'SAKIP', 'Laporan Triwulan', 'Laporan Tahunan'],
        'Pengawasan dan Audit' => ['LHP BPK', 'LHP Inspektorat', 'Tindak Lanjut Audit'],
        'Kerja Sama' => ['MoU', 'PKS'],
        'Statistik dan Data' => ['Statistik Sektoral', 'Metadata Statistik', 'Buku Statistik'],
        'Teknologi Informasi' => ['SPBE', 'Arsitektur SPBE', 'Masterplan TIK', 'Keamanan Informasi'],
        'Aset Daerah' => ['KIB', 'Inventaris Barang', 'Penghapusan Barang'],
        'Pengumuman Lainnya' => ['Pengumuman Lainnya']
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'unit_id', 'remote_id');
    }
}
