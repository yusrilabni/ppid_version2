<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'order',
        'active',
        'show_title',
        'show_description',
        'jenis_dokumen',
        'category',
    ];
}
