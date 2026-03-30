<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'title',
        'tahun',
        'content',
        'type',
        'file',
        'cover',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];
}
