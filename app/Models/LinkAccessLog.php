<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkAccessLog extends Model
{
    protected $fillable = ['domain', 'type', 'access_count', 'last_access'];
    public $timestamps = false;
}
