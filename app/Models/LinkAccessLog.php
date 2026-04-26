<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkAccessLog extends Model
{
    // Mengembalikan ke default (tabel: link_access_logs) agar beranda normal
    protected $fillable = ['title', 'url', 'access_count', 'last_accessed_at'];
}
