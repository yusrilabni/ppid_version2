<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Informasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'published',
        'deskripsi',
        'jenis_dokumen',
        'tahun',
        'file',
        'status',
        'tanggal_upload',
        'user_id', // Add user_id to fillable
        'unit_id',
        'views_count', // Add views_count to fillable
        'download_count', // Add download_count to fillable
        'url', // Add url to fillable
        'sub_standar_layanan_id',
        'official_id',
        'lhkpn_id',
        'informasi_pemkab_id',
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $slug = Str::slug($model->title);
            $originalSlug = $slug;
            $count = 1;
            
            // This loop ensures that the slug is unique
            while (static::where('slug', $slug)->where('id', '!=', $model->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $model->slug = $slug;
        });
    }

    /**
     * Get the user that owns the Informasi.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // New: Get the organization that owns the Informasi based on unit_id
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'unit_id', 'remote_id');
    }

    public function getCategorySlugAttribute()
    {
        $category = $this->attributes['category'];
        if ($category === 'Informasi Tersedia Setiap Saat') {
            return 'setiap-saat';
        }
        $slug = strtolower(str_replace(' ', '-', $category));
        
        return str_replace('informasi-', '', $slug);
    }

    public function subStandarLayanan()
    {
        return $this->belongsTo(SubStandarLayanan::class, 'sub_standar_layanan_id');
    }

    public function official()
    {
        return $this->belongsTo(Official::class);
    }

    public function lhkpn()
    {
        return $this->belongsTo(Lhkpn::class);
    }
}
