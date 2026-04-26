<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalLinkLog extends Model
{
    protected $table = 'ppid_external_logs';
    protected $fillable = ['domain', 'type', 'access_count', 'last_access'];
    public $timestamps = false;
}
