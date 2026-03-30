<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkAccessLog extends Model
{
    use HasFactory;

    protected $table = 'link_access_logs'; // Specify the table name

    protected $fillable = [
        'url',
        'title',
        'access_count',
        'last_accessed_at',
    ];

    protected $casts = [
        'last_accessed_at' => 'datetime',
    ];
}
