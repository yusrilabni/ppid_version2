<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'url',
        'ip_address',
        'origin',
        'user_agent',
        'payload',
        'user_id',
        'response_status',
        'response_time',
        'risk_level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
