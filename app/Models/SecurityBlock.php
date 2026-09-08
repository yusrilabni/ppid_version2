<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityBlock extends Model
{
    protected $fillable = ['ip_address', 'reason', 'request_data'];

    protected $casts = [
        'request_data' => 'array',
    ];
}
